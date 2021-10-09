import React, {useState} from 'react';
import axios from 'axios';
import Loading from '../parts/Loading';

interface Props {
    title: string
}

interface InputData {
    reservationDate: string
}

const initialInputData: InputData = {
    reservationDate: '',
}

interface RData {
    name: string
    reservation_time: string
}

const rData: RData = {
    name: '',
    reservation_time: ''
}

const ReservatinTop: React.FC<Props> = (props) => {

    const [reservations, getReservations] = useState([rData]);
    const [data, setData] = useState<InputData>(initialInputData);
    const [loadingDispFlag, setLoadingDispFlag] = useState<Boolean>(false);

    const getReservationsByData = async (event: React.ChangeEvent<HTMLInputElement>) => {
        try {
            const value: string = event.target.value;
            setLoadingDispFlag(true);
            setData({ ...data, reservationDate: value });
            const response = await axios.get(`/api/admin/reservation?reservationDate=${value}`);
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
                <label className="font-bold">予約日：　<input className="border-2 border-black border-solid p-0.5 rounded" type="date" value={data.reservationDate} onChange={getReservationsByData}/></label>
                <table className="text-left mt-5" width="70%">
                    <thead>
                        <tr className="border-b-2 border-gray-500 border-solid text-blue-400">
                            <th>予約時間</th>
                            <th>氏名</th>
                        </tr>
                    </thead>
                    {/* 
                        reservations[0]　　　　　　 ⇛　指定日に予約者がいない場合のエラー回避
                        reservations[0].name !=''　⇛　初期render時の空白の場合、セルの背景が見える不具合回避
                    */}
                    {reservations[0] && reservations[0].name !='' && reservations.map((resev, index) =>
                        <tbody key={index}> 
                            <tr className="border-b-2 border-gray-500 border-solid bg-white h-16">
                                <td key={index}>{resev.reservation_time}</td>
                                <td>{resev.name}</td>
                            </tr>
                        </tbody>
                    )}
                </table>
            </div>
            {loadingDispFlag && <Loading />}
        </>
    );
}
export default ReservatinTop;

