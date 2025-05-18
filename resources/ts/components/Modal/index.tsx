import * as React from 'react';

import Dialog from '@mui/material/Dialog';
import DialogContent from '@mui/material/DialogContent';
import DialogTitle from '@mui/material/DialogTitle';

type ModalProps = {
  open: boolean;
  title: string;
  contents: React.ReactNode;
}

export default function Modal({ open, title, contents }: ModalProps) {
  return (
    <React.Fragment>
      <Dialog
        open={open}
        // onClose={handleClose} open propsだけで完結せえへんか
      >
        <DialogTitle>{title}</DialogTitle>
        <DialogContent>
          {contents}
        </DialogContent>
      </Dialog>
    </React.Fragment>
  );
}