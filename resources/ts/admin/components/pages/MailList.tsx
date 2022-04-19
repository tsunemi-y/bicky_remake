import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useHistory  } from 'react-router-dom';
import Loading from '../parts/Loading';

interface Props {
    title: string
    detailUrl: string
}

interface InputData {
    name: string
}

const initialInputData: InputData = {
    name: '',
}

interface RData {
    id: number
    name: string
    email: string
}

const rData = {
    id: 0,
    name: '',
    email: ''
}

const MailList: React.FC<Props> = (props) => {

    const [users, setUsers] = useState<any>(rData);
    const [data, setData] = useState<InputData>(initialInputData);
    const [loadingDispFlag, setLoadingDispFlag] = useState<Boolean>(false);

    const {title, detailUrl} = props;

    const history = useHistory(); 

    const fetchUsers = async () => {
        setLoadingDispFlag(true);
        const response = await axios.get(`/api/admin/users?name=${data.name}`);
        setUsers(response.data);
        setLoadingDispFlag(false);
    }

    const handleOnClick = (userId: Number) => {
        history.push(`${detailUrl}${userId}`);
    }

    useEffect(() => {
        try {
            fetchUsers();
        } catch (err) {
            alert('エラーです。やり直してください。');
            setLoadingDispFlag(false);
        }
    },[]);

    const onChangeName = (event: React.ChangeEvent<HTMLInputElement>) =>  {
        const value: string = event.target.value;
        setData({ ...data, name: value });
    }

    const onClickSearchBtn = async () => {
        try {
            fetchUsers();
        } catch (err) {
            alert('エラーです。やり直してください。');
            setLoadingDispFlag(false);
        }
    }
    
    return (
        <>
            <h1　className="font-bold text-left text-2xl">{title}</h1>
            <div className="mt-3">
                <label className="font-bold">氏名：</label>
                <input className="border-2 border-black border-solid p-0.5 rounded" type="text" value={data.name} onChange={onChangeName}/>
                <div className="bg-blue-900 mt-3 p-1 rounded text-center text-white w-20">
                    <button className="w-full" onClick={onClickSearchBtn}>検索</button>
                </div>
                <table className="text-left mt-5 w-full">
                    <thead>
                        <tr className="border-b-2 border-gray-500 border-solid text-blue-400">
                            <th>氏名</th>
                            <th>メールアドレス</th>
                        </tr>
                    </thead>
                    {users[0] && users[0].id !='' && users.map((user: any, index: any) =>
                        <tbody key={index} onClick={() => handleOnClick(user.id)}>
                            <tr className="border-b-2 border-gray-500 border-solid bg-white h-16">
                                <td key={index}>
                                    {user.parentName}
                                </td>
                                <td>{user.email}</td>
                            </tr>
                        </tbody>
                    )}
                </table>
            </div>
            {loadingDispFlag && <Loading />}
        </>
    );
}
export default MailList;

