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
    email: string
    fee: number | undefined
}

interface urlParam {
    id: string | undefined
}

const rData: RData = {
    id: null,
    parentName: '',
    email: '',
    fee: undefined,
}

const EvaluationSend: React.FC<Props> = (props) => {
    const { title } = props;

    const [user, setUser] = useState(rData);
    const [fileObj, setFileObj] = useState<any>({});
    const [loadingDispFlag, setLoadingDispFlag] = useState<Boolean>(false);

    const { id }: urlParam = useParams();

    const onChangeEvaluationPDF = async (e: any) => {
        setFileObj(e.target.files);
    }

    const sendReceipt = async () =>  {
        const result: boolean = confirm(`${fileObj[0].name}を${user.parentName}さんに送信します。よろしいですか？`);
        if (result === false) return;
        try {
        setLoadingDispFlag(true);
            const params = new FormData();
            params.append('name', user.parentName);
            params.append('email', user.email);
            params.append('file', fileObj[0]);
            await axios.post('/api/admin/sendEvaluation', params, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            });
            alert('評価表の送信に成功しました。');
            setLoadingDispFlag(false);
        } catch {
            alert('評価表の送信に失敗しました。');
            setLoadingDispFlag(false);
        }
    }

    useEffect(() => {
        const fetchUsersById = async () => {
            try {
                setLoadingDispFlag(true);
                const response = await axios.get(`/api/admin/users?id=${id}`);
                setUser(response.data[0]);
                setLoadingDispFlag(false);
            } catch (err) {
                alert('エラーです。やり直してください。');
                setLoadingDispFlag(false);
            }
        }
        fetchUsersById();
    },[]);
    
    return (
        <>
            <h1　className="font-bold text-left text-2xl">{title}</h1>
            <div className="bg-white mt-3 p-4 w-3/4">
               <p><span className="inline-block w-32">【氏名】</span>{user.parentName}</p>
               <p className="mt-3"><span className="inline-block w-32">【メール】</span>{user.email}</p>
               <p className="mt-3"><span className="inline-block w-32">【PDFファイル】</span><input type="file" accept=".pdf" onChange={onChangeEvaluationPDF} className='w-3/4'/></p>
               <div className="bg-blue-900 mt-3 p-1 rounded text-center text-white w-20">
                    <button className="w-full" onClick={sendReceipt}>送信</button>
               </div>
            </div>
            {loadingDispFlag && <Loading />}
        </>
    );
}
export default EvaluationSend;

