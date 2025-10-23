const btn = document.getElementById("chatbot-btn");
const windowChat = document.getElementById("chatbot-window");
const messages = document.getElementById("chatbot-messages");
const input = document.getElementById("userInput");
const send = document.getElementById("sendBtn");

// abrir/fechar chat
btn.addEventListener("click", () => {
  windowChat.style.display = windowChat.style.display === "flex" ? "none" : "flex";
  windowChat.style.flexDirection = "column";
});

// enviar mensagem
send.addEventListener("click", sendMessage);
input.addEventListener("keypress", e => {
  if (e.key === "Enter") sendMessage();
});

function sendMessage() {
  const text = input.value.trim();
  if (!text) return;
  addMessage(text, "user");
  input.value = "";

  fetch("chatbot_api.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ message: text })
  })
  .then(res => res.json())
  .then(data => addMessage(data.reply, "bot"))
  .catch(() => addMessage(" Erro ao conectar com o Youtan Helper.", "bot"));
}

function addMessage(text, sender) {
  const div = document.createElement("div");
  div.className = "msg " + sender;
  div.textContent = text;
  messages.appendChild(div);
  messages.scrollTop = messages.scrollHeight;
}
