import React,{ useState, useEffect } from "react";

import FullCalendar from "@fullcalendar/react"; // FullCalendarコンポーネント
import dayGridPlugin from "@fullcalendar/daygrid"; // 月間カレンダー    
import interactionPlugin from "@fullcalendar/interaction"; // ユーザー操作対応
import jaLocale from "@fullcalendar/core/locales/ja";
import { EventClickArg } from "@fullcalendar/core";

// MUIコンポーネントを利用してデザインを整えたバージョン
import {
  Box,
  Button,
  FormControl,
  InputLabel,
  MenuItem,
  Select,
  Typography,
  IconButton,
  Stack
} from "@mui/material";
import DeleteIcon from "@mui/icons-material/Delete";
import AddIcon from "@mui/icons-material/Add";


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
  const [selectedChildren, setSelectedChildren] = useState<number[]>([0]);
  const [selectedCourse, setSelectedCourse] = useState<number>(0);
  const [modalOpen, setModalOpen] = useState(false);
  const [date, setDate] = useState<string>("");
  const [time, setTime] = useState<string>("");


  useEffect(() => {
    const loadEvents = async () => {
      try {
        const reservations = await reservationService.getAvailableReservations();
        
        // 画像の内容に合わせて、available_times配列の各要素をそのままevents配列に変換
        const mapped: Event[] = [];
        // reservationsはAvailableReservation[]型なので、avaTimesは各要素でオブジェクトとして持っている前提で処理
        // 例: { avaTimes: { "2023-01-14": ["10:00:00", ...], ... }, ... }
        Object.entries(reservations.avaTimes).forEach(([date, times], index) => {
          (times as string[]).forEach((time, timeIndex) => {
            mapped.push({
              id: `${index + 1}-${timeIndex + 1}`,
              title: time,
              start: `${date}T${time}`,
            });
          });
        });
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

  const renderModalContents = (date: string, time: string) => {
    return (
      <Box>
        <Box mb={3}>
          <Typography variant="subtitle1" gutterBottom>
            利用児を選択
          </Typography>
          <Stack spacing={2}>
            {selectedChildren.map((childId, index) => (
              <Box key={index} display="flex" alignItems="center">
                <FormControl fullWidth size="small">
                  <InputLabel id={`child-select-label-${index}`}>選択してください</InputLabel>
                  <Select
                    labelId={`child-select-label-${index}`}
                    value={childId || ""}
                    label="選択してください"
                    onChange={e => {
                      const updated = [...selectedChildren];
                      updated[index] = Number(e.target.value);
                      setSelectedChildren(updated);
                    }}
                  >
                    <MenuItem value="">
                      <em>選択してください</em>
                    </MenuItem>
                    {childrenOptions.map(child => (
                      <MenuItem key={child.id} value={child.id}>
                        {child.name}
                      </MenuItem>
                    ))}
                  </Select>
                </FormControl>
                <IconButton
                  aria-label="削除"
                  color="error"
                  sx={{ ml: 1 }}
                  onClick={() => {
                    const updated = [...selectedChildren];
                    updated.splice(index, 1);
                    setSelectedChildren(updated);
                  }}
                >
                  <DeleteIcon />
                </IconButton>
              </Box>
            ))}
            <Button
              variant="outlined"
              startIcon={<AddIcon />}
              onClick={() => setSelectedChildren([...selectedChildren, 0])}
              sx={{ alignSelf: "flex-start" }}
            >
              兄弟児を追加
            </Button>
          </Stack>
        </Box>

        <Box mb={3}>
          <Typography variant="subtitle1" gutterBottom>
            コースを選択
          </Typography>
          <FormControl fullWidth size="small">
            <InputLabel id="course-select-label">選択してください</InputLabel>
            <Select
              labelId="course-select-label"
              value={selectedCourse || ""}
              label="選択してください"
              onChange={e => setSelectedCourse(Number(e.target.value))}
            >
              <MenuItem value="">
                <em>選択してください</em>
              </MenuItem>
              {courseOptions.map(course => (
                <MenuItem key={course.id} value={course.id}>
                  {course.name}
                </MenuItem>
              ))}
            </Select>
          </FormControl>
        </Box>

        <Box display="flex" justifyContent="flex-end" gap={2}>
          <Button variant="outlined" color="inherit" onClick={() => setModalOpen(false)}>
            キャンセル
          </Button>
          <Button
            variant="contained"
            color="primary"
            onClick={() =>
              createReservation({
                date,
                time,
                children: selectedChildren.map(Number),
                course: selectedCourse,
              })
            }
            disabled={
              !date ||
              !time ||
              selectedChildren.length === 0 ||
              selectedChildren.some(id => !id) ||
              !selectedCourse
            }
          >
            予約
          </Button>
        </Box>
      </Box>
    );
  };

  const openModal = (date: string, time: string) => {
    setModalOpen(true);
    setDate(date);
    setTime(time);
  }

  const handleEventClick = (info: EventClickArg) => {
    const date = info.event.start ? info.event.start.toISOString().slice(0, 10) : "";
    const time = info.event.start ? info.event.start.toTimeString().slice(0, 8) : "";
    openModal(date, time);
  }

  return (
    <React.Fragment>
      <div style={{ margin: "50px auto", textAlign: "center" }}>
        <h1>予約日選択</h1>
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
          eventClick={handleEventClick}
        />
      </div>
      {modalOpen && (
        <Modal
          open={modalOpen}
          title="予約を作成する"
          contents={renderModalContents(date, time)}
        />
      )}
    </React.Fragment>
  );
};

export default UserReservation;