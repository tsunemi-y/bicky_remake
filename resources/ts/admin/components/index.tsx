import React from 'react';
import ReactDOM from 'react-dom';
import SideMenu from './parts/SideMenu';
import ReservatinTop from './pages/ReservatinTop';
import Receipt from './pages/Receipt';
import ReceiptSend from './pages/ReceiptSend';
import { BrowserRouter as Router, Route, Switch  } from 'react-router-dom';

const Index: React.FC = () => (
    <div className="flex">
        <Router>
            <div　className="bg-blue-900 pt-5 text-white w-52">　
                <SideMenu/>
            </div>
            <div　className="bg-gray-200 h-screen pt-5 w-11/12">
                <div className="ml-5">
                    <Switch>
                        <Route path='/admin/reservation' render={ () => <ReservatinTop title={'予約一覧'}/> }/>
                        <Route path='/admin/receipt/send/:id' render={ () => <ReceiptSend title={'領収書送信'}/> }/>
                        <Route path='/admin/receipt' render={ () => <Receipt title={'領収書'}/> }/>
                    </Switch>
                </div>
            </div>
        </Router>
    </div>
);

export default Index;

if (document.getElementById('index')) {
    ReactDOM.render(<Index />, document.getElementById('index'));
}
