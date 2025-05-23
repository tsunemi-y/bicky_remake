import { Modal, Box, Typography } from '@material-ui/core';

const modalStyle = {
    position: 'absolute' as 'absolute',
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    width: '80%',
    bgcolor: 'background.paper',
    border: '2px solid #000',
    boxShadow: 24,
    p: 4,
};

interface Props {
    isShownModal: boolean,
    title: string,
    body: string[],
    closeModal: () => void
}

const _Modal = (props: Props) => {
    const { isShownModal, title, body, closeModal } = props;
    return (
        <>
            <Modal
                open={isShownModal}
                onClose={closeModal}
                aria-labelledby="modal-modal-title"
                aria-describedby="modal-modal-description"
            >
            <Box sx={modalStyle}>
            <Typography style={{ borderBottom: 'solid 1px', marginBottom: '4px' }} id="modal-modal-title" variant="h6" component="h2">
                {title}
            </Typography>
            <Typography id="modal-modal-description">
                {body}
            </Typography>
            </Box>
        </Modal>
      </>
    )
}

export default _Modal