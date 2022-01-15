import React, { useState, useEffect, useRef } from 'react';
import axios from 'axios';
import Calendar from 'react-calendar';
import 'react-calendar/dist/Calendar.css';
import dayjs from 'dayjs';
import Loading from '../parts/Loading';
import _Modal from '../parts/Modal';

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

    const [reservations, setReservations] = useState([rData]);
    const [avaTimes, setAvaTimes] = useState([rData]);
    const [loadingDispFlag, setLoadingDispFlag] = useState<Boolean>(false);
    const [date, setDate] = useState<Date>(new Date());
    const [datetime, setDatetime] = useState<String>('');
    const [isShownModal, setIsShownModal] = useState<boolean>(false);
    const [deletedTargetAvaTimes, setDeletedTargetAvaTimes] = useState<any>([]);

    const ref = useRef('abc');

    const fetchReservations = async () => {
        try {
            setLoadingDispFlag(true);
            const response = await axios.get(`/api/admin/reservation`);
            setReservations(response.data.reservations);
            setAvaTimes(response.data.avaTimes);
            setLoadingDispFlag(false);
        } catch (err) {
            alert('エラーです。やり直してください。');
            setLoadingDispFlag(false);
        }
    }

    useEffect(() => {
        fetchReservations();
    },[]);

    const getTileContent = ({ date, view }) => {
        if (view !== 'month') return null;
        const formatDate: string | never = dayjs(date).format('YYYY-MM-DD');

        const targetReservation = reservations[formatDate];
        const targetAvaTimes = avaTimes[formatDate];

        let avaTimeList: any = [];
        for(var i in targetAvaTimes){
            avaTimeList.push(<p key={ i }>{ targetAvaTimes && targetAvaTimes[i] }</p>);
        }

        if (targetReservation && targetAvaTimes) {
            return (
                <div>
                    <div>
                        <p className='font-bold'>■予約者</p>
                        <p>{targetReservation.reservationName}: {targetReservation.reservationTime}</p>
                    </div>

                    <div>
                        <p className='font-bold mt-2'>■予約可能日時</p>
                        { avaTimeList }
                    </div>
                </div>
            )

        } else if (targetReservation) {
            return (
                <div>
                    <p className='font-bold'>■予約者</p>
                    <p>{targetReservation.reservationName}: {targetReservation.reservationTime}</p>
                </div>
            )

        } else if (targetAvaTimes) {
            return (
                <div>
                    <p className='font-bold'>■予約可能日時</p>
                    { avaTimeList }
                </div>
            )
        }
    }

    const onChangeDatetime = (event: React.ChangeEvent<HTMLInputElement>) =>  {
        const value: string = event.target.value;
        setDatetime(value);
    }

    // 予約可能テーブルに予約可能日時登録
    const createDatetime = async () => {
        try {
            const result: boolean = confirm(`${datetime}を予約可能日時に設定します。よろしいですか？`);
            if (result === false) return;
            const data = {
                datetime
            }
            setLoadingDispFlag(true);
            await axios.post(`/api/admin/saveReservation`, data);
            fetchReservations();
            alert('登録に成功しました。');
        } catch (err) {
            alert('登録に失敗しました。やり直してください。');
            setLoadingDispFlag(false);
        }
      }

      // 日付押下時、モーダル内に押下した日付に紐づく時間一覧を表示させる。
    const handleOnClickDay = (selectedDay: string) => {
        const targetAvaTimes: any = avaTimes[selectedDay];
        
        let avaTimeList: any = [];
        for(var i in targetAvaTimes){
            avaTimeList.push(
                <div className="bg-red-500 mt-3 p-1 rounded text-center text-white w-20">
                    <button key={i} data-date={selectedDay} onClick={(e) => deleteDatetime(selectedDay, e.target.innerText) }>{targetAvaTimes[i]}</button>
                </div>
            );
        }
        
        setDeletedTargetAvaTimes(avaTimeList);
        setIsShownModal(true);
    }

    const deleteDatetime = async (date: String, time: String) => {
        try {
            const result: boolean = confirm(`${date} ${time}を削除します。よろしいですか？`);
            if (result === false) return;
            setLoadingDispFlag(true);
            const data = {
                date,
                time
            };
            await axios.post(`/api/admin/deleteReservation`, data);
            fetchReservations();
            alert('削除に成功しました。');
            setIsShownModal(false);
        } catch (err) {
            alert('削除に失敗しました。やり直してください。');
            setLoadingDispFlag(false);
            setIsShownModal(false);
        }
    }

    // モーダル閉じる
    const closeModal = (): void => setIsShownModal(false);
    
return (
        <>
            <h1　className="font-bold text-left text-2xl">{props.title}</h1>
            <div className="mt-3">
                <label className="font-bold mr-3" htmlFor="avaDatetime">利用可能日時追加</label>
                <input value={ datetime } onChange={onChangeDatetime} className="border-2 border-black border-solid p-0.5 rounded" type="datetime-local" id="avaDatetime"/>
                <div className="bg-blue-900 mt-3 p-1 rounded text-center text-white w-20">
                    <button className="w-full" onClick={ createDatetime }>追加</button>
                </div>
                <Calendar
                    className={ ['w-4/5', 'mt-6'] }
                    locale='ja-JP'
                    value={date}
                    formatDay={(locale: any, date: Date) => dayjs(date).format('DD')}
                    tileContent={getTileContent}
                    onClickDay={(e) => handleOnClickDay(dayjs(e).format('YYYY-MM-DD'))}
                />
            </div>
            <_Modal 
                isShownModal={ isShownModal }
                title='削除する時間を選択してください。'
                body={ deletedTargetAvaTimes }
                closeModal={ closeModal }
            />
            {loadingDispFlag && <Loading />}
        </>
    );
}
export default ReservatinTop;

