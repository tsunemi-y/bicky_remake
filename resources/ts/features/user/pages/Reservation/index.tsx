import React,{ useState, useEffect } from "react";

import FullCalendar from "@fullcalendar/react"; // FullCalendarコンポーネント
import dayGridPlugin from "@fullcalendar/daygrid"; // 月間カレンダー    
import interactionPlugin from "@fullcalendar/interaction"; // ユーザー操作対応
import jaLocale from "@fullcalendar/core/locales/ja";

import Modal from "../../../../components/Modal";

import { reservationService } from "../../../../services/reservationService";
import { userService } from "../../../../services/userService";

type Event = {
  id: string;
  title: string;
  start: string;
}

type Course = {
  id: number;
  name: string;
}

const UserReservation: React.FC = () => {
  const [events, setEvents] = useState<Event[]>([]);
  const [childrenOptions, setChildrenOptions] = useState<{ value: number; label: string }[]>([]);
  const [selectedChildren, setSelectedChildren] = useState<number[]>([]);
  const [selectedCourse, setSelectedCourse] = useState<number>("");

  const courseOptions: Course[] = [
    { id: 1, name: 'コースA' },
    { id: 2, name: 'コースB' },
  ];

  useEffect(() => {
    const loadEvents = async () => {
      try {
        const reservations = await reservationService.getAvailableReservations();
        const mapped = reservations.map((r, index) => ({
          ...r.available_times.map((time, timeIndex) => ({
            id: `${index + 1}-${timeIndex + 1}`,
            title: time,
            start: `${r.available_date}T${time}`,
          })),
        }));
        setEvents(mapped);
      } catch (error) {
        alert(error.message);
      }
    };

    const loadChildrenOptions = async () => {
      try {
        // サーバーから利用児リストを取得
        const children = await userService.getChildren();
        const options = children.map((child: { id: number; name: string }) => ({
          value: child.id,
          label: child.name,
        }));
        setChildrenOptions(options);
      } catch (error) {
        console.error('利用児情報の取得に失敗しました', error);
      }
    };

    loadEvents();
    loadChildrenOptions();
  }, []);

  const createReservation = async (date: string, time: string, children: number[], course: number) => {
    try {
      await reservationService.createReservation(date, time, children, course);
    } catch (error) {
      alert(error.message);
    }
  }

  const openModal = (date: string, time: string) => {
    /**
     * 予約を作成する
     * ・モーダルだして、そこで利用児（複数可）、コース選択できるようにする
     * ・日付、時間、利用児、コースをサービスに渡して登録
     */
    const modalTitle = "予約を作成する";

const modalContents = (
  <React.Fragment>
    <div style={{ marginBottom: '16px' }}>
      <label>利用児を選択</label>
      {selectedChildren.map((childId, index) => (
        <div key={index} style={{ display: 'flex', alignItems: 'center', marginTop: '8px' }}>
          <select
            value={childId}
        onChange={e => {
          const updated = [...selectedChildren];
          updated[index] = Number(e.target.value);
          setSelectedChildren(updated);
        }}
      >
        <option value="">選択してください</option>
        {childrenOptions.map(child => (
          <option key={child.id} value={child.id}>
            {child.name}
          </option>
        ))}
      </select>
        
      <button
        type="button"
        style={{ marginLeft: '8px' }}
        onClick={() => setSelectedChildren([...selectedChildren, 0])}
      >
        兄弟児を追加
      </button>
    </div>
      )}

    <div style={{ marginBottom: '16px' }}>
      <label>コースを選択</label>
      <select
        value={selectedCourse}
        onChange={e => setSelectedCourse(Number(e.target.value))}
        style={{ marginLeft: '8px' }}
      >
        <option value="">選択してください</option>
        {courseOptions.map(course => (
          <option key={course.value} value={course.value}>
            {course.label}
          </option>
        ))}
      </select>
    </div>

    <div style={{ textAlign: 'right' }}>
      <button type="button" onClick={() => /* TODO: モーダルを閉じる */ null}>
        キャンセル
      </button>
      <button
        type="button"
        style={{ marginLeft: '8px' }}
        onClick={() => createReservation(date, time, selectedChildren, selectedCourse)}
      >
        予約
      </button>
    </div>
  </React.Fragment>
);

    return (
      <Modal open={true} title={modalTitle} contents={modalContents} />
    );

    // try {
    //   await reservationService.createReservation(date, time);
    // } catch (error) {
    //   alert(error.message);
    // }
  };

  return (
    <div style={{ margin: "50px auto", textAlign: "center" }}>
      <h1>React FullCalendar</h1>
      <FullCalendar
        locale={jaLocale}
        plugins={[dayGridPlugin, interactionPlugin]}
        initialView="dayGridMonth"
        headerToolbar={{
          left: "prev,next today",
          center: "title",
          right: "dayGridMonth,timeGridWeek,timeGridDay",
        }}
        events={events}
        editable={true}
        selectable={true}
        dateClick={(info) => openModal(info.dateStr, info.view.activeStart)}
        eventClick={(info) => alert(`イベント: ${info.event.title}`)}
      />
    </div>
  );
};

export default UserReservation;