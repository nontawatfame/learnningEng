let type = document.getElementById('operator').getAttribute('data-type')
let operator = document.getElementById('operator')
    console.log(type)
if (type === 'less') {
    operator.innerHTML = `Less than <i class="fas fa-angle-down">`
}else if (type === 'more') {
    operator.innerHTML = `More than <i class="fas fa-angle-down">`
}

var color = {
    'know': 'bg-green-400',
    'dont_know': 'bg-red-400',
    'none': 'bg-gray-400'
}

let typeGuess = document.getElementById('typeGuess').getAttribute('data-type')
let Guess = document.getElementById('typeGuess')
let valueGuess = document.getElementById('valueGuess')
let increment = document.getElementById('buttonIncrement')
let decrement = document.getElementById('buttonDecrement')
Guess.classList.remove(color['know'])
Guess.classList.remove(color['dont_know'])
Guess.classList.remove(color['none'])
if (typeGuess === 'know') {
    Guess.innerHTML = `<div class="flex justify-between">Know <div class="pt-0.5"><i class="fas fa-angle-down"></i></div></div>`
    Guess.classList.add(color['know'])
    valueGuess.classList.remove('bg-gray-200')
    increment.classList.remove('bg-gray-200')
    decrement.classList.remove('bg-gray-200')
    valueGuess.removeAttribute('disabled')
    increment.setAttribute('onclick','buttonIncrement()');
    decrement.setAttribute('onclick','buttonDecrement()');
} else if (typeGuess === 'dont_know') {
    Guess.innerHTML = `<div class="flex justify-between">Don't know <div class="pt-0.5"><i class="fas fa-angle-down"></i></div></div>`
    Guess.classList.add(color['dont_know'])
    valueGuess.classList.remove('bg-gray-200')
    increment.classList.remove('bg-gray-200')
    decrement.classList.remove('bg-gray-200')
    valueGuess.removeAttribute('disabled')
    increment.setAttribute('onclick','buttonIncrement()');
    decrement.setAttribute('onclick','buttonDecrement()');
} else if (typeGuess === 'none') {
    Guess.innerHTML = `<div class="flex justify-between">None <div class="pt-0.5"><i class="fas fa-angle-down"></i></div></div>`
    Guess.classList.add(color['none'])
    valueGuess.classList.add('bg-gray-200')
    increment.classList.add('bg-gray-200')
    decrement.classList.add('bg-gray-200')
    valueGuess.setAttribute('disabled','true')
    increment.setAttribute('onclick','');
    decrement.setAttribute('onclick','');
}

document.getElementById('valueGuess').addEventListener('keyup', (e) => {
    let inputStr = e.target.value.match(/\d/g)
    console.log(inputStr)
    if (inputStr !== null) {
        let value = '';
        for (str of inputStr) {
            value += `${str}`;
        }
        console.log(value)
        e.target.value = value
    } else if (inputStr === null) {
        e.target.value = ``
    }
})

function buttonIncrementNumber() {
    let el = document.getElementById('valueGuessNumber')
    if (el.value === '' || el.value === '0') {
        el.value = 1
    } else if (el.value >= 1) {
        let value = parseInt(el.value)
        value += 1
        let valueInput = value
        if (value > 99) {
            valueInput = value - 1
        }
        el.value = valueInput
    }
}

function buttonDecrementNumber() {
    let el = document.getElementById('valueGuessNumber')
    if (el.value === '') {
        el.value = ''
    } else if (el.value >= 1) {
        let value = parseInt(el.value)
        value -= 1
        let valueInput = value
        if (value < 1) {
            valueInput = value + 1
        }
        el.value = valueInput
    }
}

