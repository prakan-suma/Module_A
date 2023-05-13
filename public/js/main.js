function setItem(user, token) {
        localStorage.setItem('user', JSON.stringify(user))
        localStorage.setItem('token', token)
}

function getItem() {
    const user = JSON.parse(localStorage.getItem('user'))
    const token = localStorage.getItem('token')
    return { user, token }
}

function clear() {
    localStorage.clear()
}

function log(valiable) {
    console.log(valiable)
}

