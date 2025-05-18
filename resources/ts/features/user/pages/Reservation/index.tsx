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

type Child = {
  id: number;
  name: string;
}

type Course = {
  id: number;
  name: string;
  fee: number;
}

type Reservation = {
  date: string;
  time: string;
  children: number[];
  course: number;
}

const UserReservation: React.FC = () => {
  const [events, setEvents] = useState<Event[]>([]);
  const [childrenOptions, setChildrenOptions] = useState<Child[]>([]);
  const [courseOptions, setCourseOptions] = useState<Course[]>([]);
  const [selectedChildren, setSelectedChildren] = useState<number[]>([]);
  const [selectedCourse, setSelectedCourse] = useState<number>(0);

  useEffect(() => {
    const loadEvents = async () => {
      try {
        const reservations = await reservationService.getAvailableReservations();
        const mapped: Event[] = reservations.reduce((acc: Event[], r, index) => {
          const events = r.available_times.map((time, timeIndex) => ({
            id: `${index + 1}-${timeIndex + 1}`,
            title: time,
            start: `${r.available_date}T${time}`,
          }));
          return acc.concat(events);
        }, []);
        setEvents(mapped);
      } catch (error) {
        if (error instanceof Error) {
          alert(error.message);
        } else {
          alert(String(error));
        }
      }
    };

    const loadChildrenOptions = async () => {
      try {
        // サーバーから利用児リストを取得
        const children = await userService.getChildren();
        const options = children.map((child: { id: number; name: string }) => ({
          id: child.id,
          name: child.name,
        }));
        setChildrenOptions(options);
      } catch (error) {
        if (error instanceof Error) {
          alert(error.message);
        } else {
          alert(String(error));
        }
      }
    };

    const loadCourseOptions = async () => {
      try {
        // サーバーから利用児リストを取得
        const courses = await reservationService.getCourse();
        const options = courses.map((course: Course) => ({
          id: course.id,
          name: course.name,
          fee: course.fee,
        }));
        setCourseOptions(options);
      } catch (error) {
        if (error instanceof Error) {
          alert(error.message);
        } else {
          alert(String(error));
        }
      }
    };

    loadEvents();
    loadChildrenOptions();
    loadCourseOptions();
  }, []);

  const createReservation = async (data: Reservation) => {
    try {
      await reservationService.createReservation(data);
    } catch (error) {
      if (error instanceof Error) {
        alert(error.message);
      } else {
        alert(String(error));
      }
    }
  }

  const openModal = (date: string, time: string) => {
    /**
     * 予約を作成する
     * ・モーダルだして、そこで利用児（複数可）、コース選択できるようにする
     * ・日付、時間、利用児、コースをサービスに渡して登録
     */
    const modalTitle = "予約を作成する";
  }

const renderModalContents = (date: string, time: string, handleClose: () => void) => (
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
          {/* 利用児削除ボタン */}
          <button
            type="button"
            style={{ marginLeft: '8px' }}
            onClick={() => {
              const updated = [...selectedChildren];
              updated.splice(index, 1);
              setSelectedChildren(updated);
            }}
          >
            削除
          </button>
        </div>
      ))}
      {/* 兄弟児追加ボタン */}
      <button
        type="button"
        style={{ marginTop: '8px' }}
        onClick={() => setSelectedChildren([...selectedChildren, 0])}
      >
        兄弟児を追加
      </button>
    </div>

    <div style={{ marginBottom: '16px' }}>
      <label>コースを選択</label>
      <select
        value={selectedCourse}
        onChange={e => setSelectedCourse(Number(e.target.value))}
        style={{ marginLeft: '8px' }}
      >
        <option value="">選択してください</option>
        {courseOptions.map(course => (
          <option key={course.id} value={course.id}>
            {course.name}
          </option>
        ))}
      </select>
    </div>

    <div style={{ textAlign: 'right' }}>
      <button type="button" onClick={handleClose}>
        キャンセル
      </button>
      <button
        type="button"
        style={{ marginLeft: '8px' }}
        onClick={() => createReservation({date, time, children: selectedChildren.map(Number), course: selectedCourse})}
        disabled={
          !date ||
          !time ||
          selectedChildren.length === 0 ||
          selectedChildren.some(id => !id) ||
          !selectedCourse
        }
      >
        予約
      </button>
      </div>
    </React.Fragment>
  );

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
        dateClick={(info) => openModal(info.dateStr, info.view.activeStart.toISOString())}
        eventClick={(info) => alert(`イベント: ${info.event.title}`)}
      />
    </div>
  );
};

export default UserReservation;