import React, {useState} from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';
import Loading from '../parts/Loading';

interface Props {
    title: string
}

interface InputData {
    reservationDate: string
    reservationName: string
}

const initialInputData: InputData = {
    reservationDate: '',
    reservationName: '',
}

interface RData {
    id: number
    name: string
    reservation_date: string
    reservation_time: string
    email: string
    fee: number
}

const rData: RData = {
    id: 0,
    name: '',
    reservation_date: '',
    reservation_time: '',
    email: '',
    fee: 0,
}

const Receipt: React.FC<Props> = (props) => {

    const [reservations, getReservations] = useState([rData]);
    const [data, setData] = useState<InputData>(initialInputData);
    const [loadingDispFlag, setLoadingDispFlag] = useState<Boolean>(false);

    const onChangeRsvDate = (event: React.ChangeEvent<HTMLInputElement>) =>  {
        const value: string = event.target.value;
        setData({ ...data, reservationDate: value });
    }

    const onChangeRsvName = (event: React.ChangeEvent<HTMLInputElement>) =>  {
        const value: string = event.target.value;
        setData({ ...data, reservationName: value });
    }

    const onClickSearchBtn = async () => {
        try {
            setLoadingDispFlag(true);
            const response = await axios.get(`/api/admin/reservation?reservationDate=${data.reservationDate}&reservationName=${data.reservationName}`);
            getReservations(response.data);
            setLoadingDispFlag(false);
        } catch (err) {
            alert('エラーです。やり直してください。');
            setLoadingDispFlag(false);
        }
    }
    
    return (
        <>
            <h1　className="font-bold text-left text-2xl">{props.title}</h1>
            <div className="mt-3">
                <label className="font-bold">予約日：</label>
                <input className="border-2 border-black border-solid p-0.5 rounded" type="date" value={data.reservationDate} onChange={onChangeRsvDate}/>
                <label className="font-bold ml-4">氏名：</label>
                <input className="border-2 border-black border-solid p-0.5 rounded" type="text" value={data.reservationName} onChange={onChangeRsvName}/>
                <div className="bg-blue-900 mt-3 p-1 rounded text-center text-white w-20">
                    <button className="w-full" onClick={onClickSearchBtn}>検索</button>
                </div>
                <table className="text-left mt-5" width="70%">
                    <thead>
                        <tr className="border-b-2 border-gray-500 border-solid text-blue-400">
                            <th>氏名</th>
                            <th>予約日時</th>
                            <th>予約時間</th>
                            <th>メールアドレス</th>
                            <th>料金</th>
                        </tr>
                    </thead>
                    {reservations[0] && reservations[0].name !='' && reservations.map((rsv, index) =>
                        <tbody key={index}>
                            <tr className="border-b-2 border-gray-500 border-solid bg-white h-16">
                                <td key={index}>
                                    <Link to={`/admin/receipt/send/${rsv.id}`}>{rsv.name}</Link>
                                </td>
                                <td>{rsv.reservation_date}</td>
                                <td>{rsv.reservation_time}</td>
                                <td>{rsv.email}</td>
                                <td>{rsv.fee}</td>
                            </tr>
                        </tbody>
                    )}
                </table>
            </div>
            {loadingDispFlag && <Loading />}
        </>
    );
}
export default Receipt;

