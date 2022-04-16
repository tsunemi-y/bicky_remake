import React from 'react';
import { faSpinner } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";

const Loading: React.FC = () => {
    
    return (
        <>
            <div className="absolute bg-black bg-opacity-80 flex h-screen items-center justify-center left-0 top-0 w-screen">
                <FontAwesomeIcon className="animate-spin text-white" icon={faSpinner} size="5x" />
            </div>
        </>
    );
}
export default Loading;

