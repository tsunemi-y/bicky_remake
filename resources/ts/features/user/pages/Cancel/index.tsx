import React, { useState, useEffect } from 'react';
import { reservationService } from '../../../../services/reservationService';
import { useNavigate } from 'react-router-dom';
import useAuthGuard from "../../services/useAuthGuard";
import { UserReservationResponse } from '../../../../services/reservationService';

// MUIコンポーネントのインポート
import {
  Box,
  Typography,
  Button,
  CircularProgress,
  Alert,
  Dialog,
  DialogTitle,
  DialogContent,
  DialogContentText,
  DialogActions,
  Paper,
  Stack,
  Snackbar,
} from '@mui/material';

const Cancel = () => {
  const navigate = useNavigate();
  const isAuthed = useAuthGuard();

  useEffect(() => {
    if (!isAuthed) {
      navigate("/login");
    }
  }, [isAuthed, navigate]);
  if (!isAuthed) return null;

  // 予約一覧の状態
  const [reservations, setReservations] = useState<UserReservationResponse[]>([]);
  // ローディング状態
  const [loading, setLoading] = useState(true);
  // エラー状態
  const [error, setError] = useState<string | null>(null);
  const [snackbarOpen, setSnackbarOpen] = useState(false);
  const [snackbarMessage, setSnackbarMessage] = useState("");
  const [snackbarSeverity, setSnackbarSeverity] = useState<"success" | "info" | "warning" | "error">("success");
  // キャンセル確認モーダルの状態
  const [showModal, setShowModal] = useState(false);
  // キャンセル対象の予約ID
  const [selectedReservationId, setSelectedReservationId] = useState<number | null>(null);

  // 予約一覧を取得する
  useEffect(() => {
    const fetchReservations = async () => {
      try {
        setLoading(true);
        // reservationServiceからユーザーの予約一覧を取得
        const response = await reservationService.getUserReservations();
        setReservations(response);
        setError(null);
      } catch (err) {
        console.error('予約取得エラー:', err);
        setError('予約情報の取得に失敗しました。');
      } finally {
        setLoading(false);
      }
    };

    fetchReservations();
  }, []);

  // キャンセル確認ダイアログを表示
  const handleCancelClick = (reservationId: number) => {
    setSelectedReservationId(reservationId);
    setShowModal(true);
  };

  // キャンセル処理を実行
  const confirmCancel = async () => {
    if (selectedReservationId === null) return;

    try {
      setLoading(true);
      // 予約キャンセルAPIを呼び出し
      await reservationService.cancelReservation(selectedReservationId);

      navigate("/", { state: { snackbar: { message: "予約をキャンセルしました。", severity: "success" } } });

      // 予約一覧を更新
      // setReservations(reservations.map(reservation =>
      //   reservation.id === selectedReservationId
      //     ? { ...reservation, status: 'cancelled' }
      //     : reservation
      // ));
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
      setShowModal(false);
      setLoading(false);
    }
  };

  // キャンセル確認ダイアログを閉じる
  const closeModal = () => {
    setShowModal(false);
    setSelectedReservationId(null);
  };

  return (
    <Box sx={{ maxWidth: 600, mx: 'auto', p: 3 }}>
      <Typography variant="h4" component="h1" gutterBottom>
        予約確認・キャンセル
      </Typography>

      {loading && (
        <Box sx={{ display: 'flex', justifyContent: 'center', my: 4 }}>
          <CircularProgress />
        </Box>
      )}

      {error && (
        <Alert severity="error" sx={{ mb: 2 }}>
          {error}
        </Alert>
      )}

      {!loading && !error && (
        <>
          {reservations.length === 0 ? (
            <Typography variant="body1" color="text.secondary">
              現在予約はありません。
            </Typography>
          ) : (
            <Stack spacing={2}>
              {reservations.map(reservation => (
                <Paper
                  key={reservation.id}
                  elevation={2}
                  sx={{
                    p: 2,
                    display: 'flex',
                    justifyContent: 'space-between',
                    alignItems: 'center',
                  }}
                >
                  <Box>
                    <Typography variant="subtitle1" sx={{ fontWeight: 'bold' }}>
                      {reservation.reservation_date} {reservation.reservation_time}
                    </Typography>
                  </Box>
                  <Box>
                    <Button
                      variant="outlined"
                      color="error"
                      onClick={() => handleCancelClick(reservation.id)}
                    >
                      この予約をキャンセルする
                    </Button>
                  </Box>
                </Paper>
              ))}
            </Stack>
          )}
          <Snackbar
            open={snackbarOpen}
            autoHideDuration={4000}
            onClose={() => setSnackbarOpen(false)}
            anchorOrigin={{ vertical: "top", horizontal: "center" }}
          >
            <Alert onClose={() => setSnackbarOpen(false)} severity={snackbarSeverity} sx={{ width: '100%' }}>
              {snackbarMessage.split('\n').map((line, index) => (
                <React.Fragment key={index}>
                  {line}
                  {index !== snackbarMessage.split('\n').length - 1 && <br />}
                </React.Fragment>
              ))}
            </Alert>
          </Snackbar>
        </>
      )}

      {/* キャンセル確認モーダル */}
      <Dialog open={showModal} onClose={closeModal}>
        <DialogTitle>予約キャンセルの確認</DialogTitle>
        <DialogContent>
          <DialogContentText>
            この予約をキャンセルしてもよろしいですか？
          </DialogContentText>
          <DialogContentText sx={{ color: 'error.main', mt: 1 }}>
            ※キャンセル後の復旧はできません。
          </DialogContentText>
        </DialogContent>
        <DialogActions>
          <Button
            onClick={confirmCancel}
            color="error"
            variant="contained"
            disabled={loading}
          >
            キャンセルする
          </Button>
          <Button
            onClick={closeModal}
            color="inherit"
            variant="outlined"
            disabled={loading}
          >
            戻る
          </Button>
        </DialogActions>
      </Dialog>
    </Box>
  );
};

export default Cancel;
