import * as React from 'react';

import Dialog from '@mui/material/Dialog';
import DialogContent from '@mui/material/DialogContent';
import DialogTitle from '@mui/material/DialogTitle';
import IconButton from '@mui/material/IconButton';
import CloseIcon from '@mui/icons-material/Close';
import Slide from '@mui/material/Slide';
import { styled } from '@mui/material/styles';
import Paper from '@mui/material/Paper';

type ModalProps = {
  open: boolean;
  title: string;
  contents: React.ReactNode;
  onClose?: () => void;
};

// モーダルのサイズをもう少し大きくする
const StyledDialog = styled(Dialog)(({ theme }) => ({
  '& .MuiPaper-root': {
    borderRadius: 24,
    padding: theme.spacing(2.5, 4, 4, 4),
    minWidth: 520, // 400→520
    maxWidth: 800, // 600→800
    width: '100%',
    background: 'rgba(255,255,255,0.95)',
    boxShadow: '0 8px 32px 0 rgba(31, 38, 135, 0.37)',
    backdropFilter: 'blur(8px)',
    border: '1px solid rgba(255,255,255,0.18)',
    [theme.breakpoints.down('sm')]: {
      minWidth: 'unset',
      maxWidth: '98vw', // 90vw→98vw
      padding: theme.spacing(2, 1.5, 2.5, 1.5),
    },
  },
}));

const StyledDialogTitle = styled(DialogTitle)(({ theme }) => ({
  fontWeight: 700,
  fontSize: '1.7rem', // 1.5rem→1.7rem
  letterSpacing: '0.02em',
  display: 'flex',
  alignItems: 'center',
  justifyContent: 'space-between',
  paddingRight: theme.spacing(1.5),
  paddingLeft: theme.spacing(1.5),
  borderBottom: `1px solid ${theme.palette.divider}`,
}));

const StyledDialogContent = styled(DialogContent)(({ theme }) => ({
  marginTop: theme.spacing(2.5),
  fontSize: '1.15rem', // 1.1rem→1.15rem
}));

const Transition = React.forwardRef(function Transition(
  props: any,
  ref: React.Ref<unknown>,
) {
  return <Slide direction="up" ref={ref} {...props} />;
});

export default function Modal({ open, title, contents, onClose }: ModalProps) {
  return (
    <StyledDialog
      open={open}
      onClose={onClose}
      keepMounted
      aria-labelledby="modern-modal-title"
      aria-describedby="modern-modal-description"
      PaperComponent={Paper}
    >
      <StyledDialogTitle id="modern-modal-title">
        {title}
        {onClose && (
          <IconButton
            aria-label="close"
            onClick={onClose}
            sx={{
              marginLeft: 1,
              color: (theme) => theme.palette.grey[500],
            }}
            size="large"
          >
            <CloseIcon />
          </IconButton>
        )}
      </StyledDialogTitle>
      <StyledDialogContent id="modern-modal-description">
        {contents}
      </StyledDialogContent>
    </StyledDialog>
  );
}