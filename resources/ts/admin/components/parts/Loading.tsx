import React from 'react';
import { faSpinner } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";

const Loading: React.FC = () => {
    
    return (
        <>
            <div className="absolute bg-black bg-opacity-80 h-screen left-0 top-0 w-screen">
                <FontAwesomeIcon className="absolute animate-spin left-1/2 text-white top-1/2" icon={faSpinner} size="5x" />
            </div>
        </>
    );
}
export default Loading;

