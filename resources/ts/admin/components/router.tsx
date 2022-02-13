import { 
    BrowserRouter, 
    Switch,
    Route
} from 'react-router-dom';

import SideMenu from './parts/SideMenu';
import ReservatinTop from './pages/ReservatinTop';
import Receipt from './pages/Receipt';
import ReceiptSend from './pages/ReceiptSend';
import Evaluation from './pages/Evaluation';
import EvaluationSend from './pages/EvaluationSend';

const Router = () => {
    return (
        <BrowserRouter>
            <div　className="bg-blue-900 pt-5 text-white w-52">　
                <SideMenu/>
            </div>

            <div　className="bg-gray-200 h-screen pt-5 w-11/12">
                <div className="ml-5">
                    <Switch>
                        <Route path='/admin/receipt/send/:id' render={ () => <ReceiptSend title={'領収書送信'}/> }/>
                        <Route path='/admin/evaluation/send/:id' render={ () => <EvaluationSend title={'評価表送信'}/> }/>
                        <Route path='/admin/reservation' render={ () => <ReservatinTop title={'予約一覧'}/> }/>
                        <Route path='/admin/receipt' render={ () => <Receipt title={'領収書'}/> }/>
                        <Route path='/admin/evaluation' render={ () => <Evaluation title={'評価表'}/> }/>
                    </Switch>
                </div>
            </div>
        </BrowserRouter>
    )
}

export default Router