
import React, { useState } from "react";

const MessageInput = ({ rootUrl, user, isBroadcasting }) => {
    const [message, setMessage] = useState("");
    const userId = user.id;
    const is_broadcasting = isBroadcasting;

    const messageRequest = async (text) => {
        try {
            await axios.post(`${rootUrl}/message`, {
                text,
                userId,
                is_broadcasting
            });
        } catch (err) {
            console.log(err.message);
        }
    };

    const sendMessage = (e) => {
        e.preventDefault();
        // console.log(userId);
        if (message.trim() === "") {
            alert("Please enter a message!");
            return;
        }
        messageRequest(message);
        setMessage("");
    };

    return (
        <div className="input-group">
            <input onChange={(e) => setMessage(e.target.value)}
                   autoComplete="off"
                   type="text"
                   className="form-control"
                   placeholder="Message..."
                   value={message}
            />
            <input type="hidden" name="userId" value={1} id="userId" />
            <div className="input-group-append">
                <button onClick={(e) => sendMessage(e)}
                        className="btn btn-primary"
                        type="button">Send</button>
            </div>
        </div>
    );
};

export default MessageInput;
