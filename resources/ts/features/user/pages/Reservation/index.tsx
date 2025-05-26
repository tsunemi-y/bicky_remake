/**
 * TODO
 * 利用時選択したらその利用時は兄弟児セレクトボックスに表示されないようにする
 * 年齢・人数によって表示するコースを制御
 * feeTableのデータをサーバーから取得する（定数化）
 * 先にコースと人数選択してもらって利用時間決まってから時間しぼらなあかん
 * 
 * 
 */

import React,{ useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";

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
  Stack,
  Snackbar,
  Alert
} from "@mui/material";
import DeleteIcon from "@mui/icons-material/Delete";
import AddIcon from "@mui/icons-material/Add";

import Modal from "../../../../components/Modal";
import Loading from "../../../../components/Loading";

import { reservationService } from "../../../../services/reservationService";
import { userService } from "../../../../services/userService";
import { calculateIsTablet } from "survey-core/typings/src/utils/devices";

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
  fee?: number;
  useTime?: number;
}

const UserReservation: React.FC = () => {
  const navigate = useNavigate();

  const [events, setEvents] = useState<Event[]>([]);
  const [childrenOptions, setChildrenOptions] = useState<Child[]>([]);
  const [courseOptions, setCourseOptions] = useState<Course[]>([]);
  const [selectedChildren, setSelectedChildren] = useState<number[]>([0]);
  const [selectedCourse, setSelectedCourse] = useState<number>(0);
  const [modalOpen, setModalOpen] = useState(false);
  const [isLoading, setIsLoading] = useState(false);
  const [snackbarOpen, setSnackbarOpen] = useState(false);
  const [snackbarMessage, setSnackbarMessage] = useState("");
  const [snackbarSeverity, setSnackbarSeverity] = useState<"success" | "info" | "warning" | "error">("success");
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
    
    const token = localStorage.getItem("access_token");
    if (!token) {
      navigate("/login", { replace: true });
    }

    loadEvents();
    loadChildrenOptions();
    loadCourseOptions();
  }, []);

  type UseTimeTable = {
    [courseId: number]: number | { [childrenCount: number]: number };
  };

  const useTimeTable: UseTimeTable = {
    1: 60,
    4: 60,
    5: 90,
    2: {
      2: 90,
      3: 120,
    },
    3: {
      2: 120,
      3: 180,
    },
  };


  // コースごとの料金テーブルを定義し、保守性・可読性を向上
  type FeeTable = {
    [courseId: number]: number | { [childrenCount: number]: number }
  };

  const feeTable: FeeTable = {
    1: 8800,
    4: 8800,
    5: 13200,
    2: {
      2: 13200,
      3: 19800,
    },
    3: {
      2: 17600,
      3: 26400,
    },
  };

  const calculateFee = (children: number[], course: number): number => {
    const feeInfo = feeTable[course];
    if (typeof feeInfo === "number") {
      return feeInfo;
    }
    if (typeof feeInfo === "object" && feeInfo !== null) {
      return feeInfo[children.length] ?? 0;
    }
    return 0;
  }

  const calculateUseTime = (children: number[], course: number): number => {
    const useTime = useTimeTable[course];
    if (typeof useTime === "number") {
      return useTime;
    }
    if (typeof useTime === "object" && useTime !== null) {
      return useTime[children.length] ?? 0;
    }
    return 0;
  }

  const createReservation = async (data: Reservation) => {
    const fee = calculateFee(data.children, data.course)
    const useTime = calculateUseTime(data.children, data.course);

    const confirmMessage = `
        予約を作成しますか？

        利用日時: ${data.date} ${data.time}
        利用児: ${data.children.map(child => childrenOptions.find(c => c.id === child)?.name).join(", ")}
        コース: ${courseOptions.find(c => c.id === data.course)?.name}
        料金: ${fee.toLocaleString()}円
        利用時間: ${useTime}分
      `;
      
    const confirmed = confirm(confirmMessage);
    if (!confirmed) {
      return;
    }

    data.fee = fee;
    data.useTime = useTime;

    try {
      setModalOpen(false);
      setIsLoading(true);
      const reservation = await reservationService.createReservation(data);

      setSnackbarMessage(reservation.message);
      setSnackbarSeverity("success");
      setSnackbarOpen(true);

    } catch (error) {
      if (error instanceof Error) {
        setSnackbarMessage(error.message);
        setSnackbarSeverity("error");
        setSnackbarOpen(true);
      } else {
        setSnackbarMessage(String(error));
        setSnackbarSeverity("error");
        setSnackbarOpen(true);
      }
    } finally {
      setIsLoading(false);
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
      <Loading is_loading={isLoading} />
      <Snackbar
        open={snackbarOpen}
        autoHideDuration={4000}
        onClose={() => setSnackbarOpen(false)}
        anchorOrigin={{ vertical: "top", horizontal: "center" }}
      >
        <Alert onClose={() => setSnackbarOpen(false)} severity={snackbarSeverity} sx={{ width: '100%' }}>
          {snackbarMessage}
        </Alert>
      </Snackbar>
    </React.Fragment>
  );
};

export default UserReservation;