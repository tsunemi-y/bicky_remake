import React, {useState} from 'react';
import { Link } from 'react-router-dom';
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCalendarCheck, faAngleDown } from "@fortawesome/free-solid-svg-icons";


const SideReservation: React.FC<any> = (props) => {
    const { toggleSideMunu } = props;
    const [toggle, setToggle] = useState<Boolean>(true);

    return (
        <>
            <li>
                <span className="inline-block w-24">
                    <FontAwesomeIcon className="mr-1 text-white" icon={faCalendarCheck} />  
                    予約
                </span>
                <FontAwesomeIcon className="ml-3 text-white" icon={faAngleDown} onClick={e => setToggle(!toggle)}/>
                <ul className={toggle ? "transition duration-700 h-8" : "h-0 overflow-hidden"}>
                    <li  >
                        <Link onClick={toggleSideMunu} to="/admin/reservation">予約一覧</Link>
                    </li>
                </ul>
            </li>
        </>
    );
}
    
export default SideReservation;

