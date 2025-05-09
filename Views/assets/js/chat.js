document.addEventListener("DOMContentLoaded", function () {
  const chatBox = document.getElementById("chat-box");
  const bugId = document.querySelector('input[name="bug_id"]').value;
  const userId = document.querySelector('input[name="sender_id"]').value;

  function fetchMessages() {
    fetch(`get_messages.php?bug_id=${bugId}&user_id=${userId}`)
      .then((response) => response.json())
      .then((data) => {
        chatBox.innerHTML = ""; // Clear existing messages
        data.forEach((msg) => {
          const isSender = msg.sender_id == userId;
          const messageHtml = `
                        <div class="direct-chat-msg ${isSender ? "end" : ""}">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name ${
                                  isSender ? "float-end" : "float-start"
                                }">
                                    ${msg.sender_name}
                                </span>
                                <span class="direct-chat-timestamp ${
                                  isSender ? "float-start" : "float-end"
                                }">
                                    ${msg.sent_at}
                                </span>
                            </div>
                            <img class="direct-chat-img" src="../assets/img/${
                              isSender
                                ? "user3-128x128.jpg"
                                : "user1-128x128.jpg"
                            }" alt="user image">
                            <div class="direct-chat-text">
                                ${msg.message}
                            </div>
                        </div>
                    `;
          chatBox.innerHTML += messageHtml;
        });
        chatBox.scrollTop = chatBox.scrollHeight; // Scroll to bottom
      })
      .catch((error) => console.error("Error fetching messages:", error));
  }

  fetchMessages();
  setInterval(fetchMessages, 5000); // Poll every 5 seconds
});
