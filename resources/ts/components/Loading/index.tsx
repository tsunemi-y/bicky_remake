import React from 'react';
import CircularProgress from '@mui/material/CircularProgress';
import Box from '@mui/material/Box';

export default function Loading({ is_loading }: { is_loading: boolean }) {
  if (!is_loading) return null;

  return (
    <Box
      sx={{
        position: 'fixed',
        top: 0,
        left: 0,
        width: '100vw',
        height: '100vh',
        bgcolor: 'rgba(255,255,255,0.5)', // 半透明の白背景
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        zIndex: 1300, // MUIのモーダルと同等
      }}
    >
      <CircularProgress />
    </Box>
  );
}
