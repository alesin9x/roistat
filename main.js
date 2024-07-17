let boolean = false;

const send = async () => {
    const inputs = document.querySelectorAll("input");
    const data = {boolean};

    for (const input of inputs) {
        data[input.id] = input.value;
    }

    console.log(data)
}