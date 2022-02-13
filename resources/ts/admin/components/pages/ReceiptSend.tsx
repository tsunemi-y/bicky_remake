import React, {useState, useEffect} from 'react';
import axios from 'axios';
import { useParams } from 'react-router-dom';
import Loading from '../parts/Loading';

interface Props {
    title: string
}

interface RData {
    id: number | null
    parentName: string
    reservation_date: string
    reservation_time: string
    email: string
    fee: number | undefined
}

interface urlParam {
    id: string | undefined
}

const rData: RData = {
    id: null,
    parentName: '',
    reservation_date: '',
    reservation_time: '',
    email: '',
    fee: undefined,
}

const ReceiptSend: React.FC<Props> = (props) => {

    const [reservations, setReservations] = useState(rData);
    const [loadingDispFlag, setLoadingDispFlag] = useState<Boolean>(false);

    const { id }: urlParam = useParams();

    const onChangeFee = async (event: React.ChangeEvent<HTMLInputElement>) => {
        setLoadingDispFlag(true);
        const value: number = parseInt(event.target.value, 10);
        setReservations({ ...reservations, fee: value });
        await axios.put(`/api/admin/updateReservation/${id}`, {fee: value});
        setLoadingDispFlag(false);
    }

    const sendReceipt = async () =>  {
        try {
            setLoadingDispFlag(true);
            const args = {
                name: reservations.parentName,
                date: reservations.reservation_date,
                time: reservations.reservation_time,
                email: reservations.email,
                fee: reservations.fee
            }
            await axios.post('/api/admin/sendReceipt', args);
            alert('領収書の送信に成功しました。');
            setLoadingDispFlag(false);
        }catch (err) {
            alert('エラーです。やり直してください。');
            setLoadingDispFlag(false);
        }
    }

    useEffect(() => {
        const fetchReservationById = async () => {
            try {
                setLoadingDispFlag(true);
                const response = await axios.get(`/api/admin/getUserInfoSendReciept?id=${id}`);
                setReservations(response.data[0]);
                setLoadingDispFlag(false);
            } catch (err) {
                alert('エラーです。やり直してください。');
                setLoadingDispFlag(false);
            }
        }
        fetchReservationById();
    },[]);
    
    return (
        <>
            <h1　className="font-bold text-left text-2xl">{props.title}</h1>
            <div className="bg-white mt-3 p-4 w-3/4">
               <p><span className="inline-block w-32">【氏名】</span>{reservations.parentName}</p>
               <p className="mt-3"><span className="inline-block w-32">【予約日】</span>{reservations.reservation_date}</p>
               <p className="mt-3"><span className="inline-block w-32">【予約時間】</span>{reservations.reservation_time}</p>
               <p className="mt-3"><span className="inline-block w-32">【メール】</span>{reservations.email}</p>
               <p className="mt-3"><span className="inline-block w-32">【料金】</span><input className="border rounded" onBlur={onChangeFee} defaultValue={reservations.fee}/></p>
               <div className="bg-blue-900 mt-3 p-1 rounded text-center text-white w-20">
                    <button className="w-full" onClick={sendReceipt}>送信</button>
               </div>
            </div>
            {loadingDispFlag && <Loading />}
        </>
    );
}
export default ReceiptSend;

