import React from "react";
import FullCalendar from "@fullcalendar/react"; // FullCalendarコンポーネント
import dayGridPlugin from "@fullcalendar/daygrid"; // 月間カレンダー    
import interactionPlugin from "@fullcalendar/interaction"; // ユーザー操作対応
import jaLocale from "@fullcalendar/core/locales/ja";

const UserReservation: React.FC = () => {
  const events = [
    { id: "1", title: "◯", start: "2025-05-09T10:00:00",},
    { id: "1", title: "◯", start: "2025-05-09T12:00:00",},
    { id: "1", title: "◯", start: "2025-05-09T13:00:00",},
    { id: "1", title: "◯", start: "2025-05-09T14:00:00",},
  ];

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
        dateClick={(info) => alert(`日付がクリックされました: ${info.dateStr}`)}
        eventClick={(info) => alert(`イベント: ${info.event.title}`)}
      />
    </div>
  );
};

export default UserReservation;