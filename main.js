let boolean = false;
let currentSeconds = 0;
const endSeconds = 3;

const updateTime = () => {
    currentSeconds++;
}

// Запускаем таймер
const intervalId = setInterval(updateTime, 1000); // 1000 миллисекунд = 1 секунда

// Очистка таймера после завершения
setTimeout(() => {
    clearInterval(intervalId);
    boolean = true;
}, endSeconds * 1000);


const send = async () => {
    const inputs = document.querySelectorAll("input");
    const data = { boolean };

    for (const input of inputs) {
        data[input.id] = input.value;
    }

    await postData('/api/deal.php', data);
}

const postData = async (url, body) => {
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        }
    }
    if (body) {
        options.body = JSON.stringify(body)
    }

    try {
        const res = await fetch(url, options)
        if (!res.ok) {
            alert('Ошибка при получении данных');
        }
        return await res.json()
    } catch (e) {
        alert('Ошибка при получении данных');
    }
}