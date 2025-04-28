import React from 'react';
import MailList from './MailList';

interface Props {
    title: string
}

const Receipt: React.FC<Props> = (props) => {
    const { title } = props;

    return (
        <>
            <MailList title={title} detailUrl={'/admin/evaluation/send/'}/>
        </>
    );
}
export default Receipt;

