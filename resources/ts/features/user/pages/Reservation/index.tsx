import React,{ useState, useEffect, useMemo } from "react";
import { useNavigate, useLocation } from "react-router-dom";

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
  Alert,
  Breadcrumbs,
  Link as MuiLink,
} from "@mui/material";
import DeleteIcon from "@mui/icons-material/Delete";
import AddIcon from "@mui/icons-material/Add";

import Modal from "../../../../components/Modal";
import Loading from "../../../../components/Loading";

import { reservationService } from "../../../../services/reservationService";
import { userService } from "../../../../services/userService";
import { calculateIsTablet } from "survey-core/typings/src/utils/devices";
import { Link as RouterLink } from "react-router-dom";

import useAuthGuard from "../../services/useAuthGuard";
import "./styles.module.css";

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
  const location = useLocation();

  const isAuthed = useAuthGuard();
  
  useEffect(() => {
    if (!isAuthed) {
      navigate("/login");
    }
  }, [isAuthed, navigate]);
  if (!isAuthed) return null;

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

  // 追加: 遷移時のsnackbar表示
  useEffect(() => {
    if (
      location.state &&
      typeof location.state === "object" &&
      "snackbar" in location.state &&
      location.state.snackbar &&
      typeof location.state.snackbar === "object"
    ) {
      const { message, severity } = location.state.snackbar;
      if (message) {
        setSnackbarMessage(message);
        setSnackbarSeverity(severity || "success");
        setSnackbarOpen(true);
        // 履歴のstateを消す（再表示防止）
        navigate(location.pathname, { replace: true, state: {} });
      }
    }
    
  }, [location.state, navigate, location.pathname]);

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
          setSnackbarMessage(error.message);
          setSnackbarSeverity("error");
          setSnackbarOpen(true);
        } else {
          setSnackbarMessage(String(error));
          setSnackbarSeverity("error");
          setSnackbarOpen(true);
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
          setSnackbarMessage(error.message);
          setSnackbarSeverity("error");
          setSnackbarOpen(true);
        } else {
          setSnackbarMessage(String(error));
          setSnackbarSeverity("error");
          setSnackbarOpen(true);
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
          setSnackbarMessage(error.message);
          setSnackbarSeverity("error");
          setSnackbarOpen(true);
        } else {
          setSnackbarMessage(String(error));
          setSnackbarSeverity("error");
          setSnackbarOpen(true);
        }
      }
    };

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
        以下の内容で予約を確定しますか？

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

      navigate("/", { state: { snackbar: { message: reservation.message, severity: "success" } } });

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

  // 利用児セレクトボックスで既に選択されている子は他のセレクトボックスで選択肢に出さない
  const getAvailableChildrenOptions = (index: number) => {
    // index番目のセレクトボックスは自分自身の値は選択肢に含める
    const selectedExceptCurrent = selectedChildren.filter((_, i) => i !== index);
    return childrenOptions.filter(child => !selectedExceptCurrent.includes(child.id));
  };

  // 利用人数によって表示するコースを制御
  // 1人のときは1,4,5、2人以上のときは2,3
  const getFilteredCourseOptions = useMemo(() => {
    const count = selectedChildren.filter(id => !!id).length;
    if (count === 1) {
      // 1人のとき
      return courseOptions.filter(course => [1, 4, 5].includes(course.id));
    } else if (count >= 2) {
      // 2人以上のとき
      return courseOptions.filter(course => [2, 3].includes(course.id));
    } else {
      // 0人のときは全て非表示
      return [];
    }
  }, [courseOptions, selectedChildren]);

  // 選択児童数とコースの整合性を保つ（人数変更時に選択中コースが選択不可になったらリセット）
  useEffect(() => {
    if (
      selectedCourse &&
      !getFilteredCourseOptions.some(course => course.id === selectedCourse)
    ) {
      setSelectedCourse(0);
    }
  }, [selectedChildren, getFilteredCourseOptions, selectedCourse]);

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
                    {getAvailableChildrenOptions(index).map(child => (
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
                  disabled={selectedChildren.length === 1}
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
              disabled={selectedChildren.length >= childrenOptions.length}
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
              {getFilteredCourseOptions.map(course => (
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
      <Box sx={{ mt: 3, mb: 2 }}>
        <Breadcrumbs aria-label="breadcrumb">
          <MuiLink component={RouterLink} underline="hover" color="inherit" to="/">
            TOP
          </MuiLink>
          <Typography color="text.primary">予約</Typography>
        </Breadcrumbs>
      </Box>
      <div>
        <FullCalendar
          locale={jaLocale}
          plugins={[dayGridPlugin, interactionPlugin]}
          initialView="dayGridMonth"
          headerToolbar={{
            left: "prev",
            center: "title",
            right: "next",
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