import React from "react";

const Message = ({ userId, message }) => {
    // console.log(message.receiver_id == null);
    const isReceiverId = message.receiver_id == null;
    return (
        <div>
            {isReceiverId ? (
                <div
                    className={`row ${
                        userId === message.user_id ? "justify-content-end" : ""
                    }`}
                >
                    <div className="col-md-6"> 
                        <small className="text-muted">
                            {message.user.name}
                            {" "}
                        </small>
                        <small className="text-muted float-right ">
                            {message.time}
                        </small>
                        <div
                            className={`alert alert-${
                                userId === message.user_id
                                    ? "primary"
                                    : "secondary"
                            }`}
                            role="alert"
                        >
                            {message.text}
                        </div>
                    </div>
                </div>
            ) : (
                <div
                    className={`row ${
                        userId === message.receiver_id
                            ? "justify-content-end"
                            : ""
                    }`}
                >
                    <div className="col-md-6">
                        <small className="text-muted float-right">
                            {message.time}
                        </small>
                        <small className="text-muted">{message.name}</small>
                        <div
                            className={`alert alert-${
                                userId === message.receiver_id
                                    ? "primary"
                                    : "secondary"
                            }`}
                            role="alert"
                        >
                            {message.text}
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

export default Message;
