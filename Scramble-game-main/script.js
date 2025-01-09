// Array of words with their corresponding hints

let words = [
  // Each object represents a word and its hint
  {
    word: "apple",
    hint: "A red, round fruit.",
  },
  {
    word: "bird",
    hint: "An animal that can fly.",
  },
  {
    word: "sun",
    hint: "The big yellow ball in the sky",
  },
  {
    word: "zoo",
    hint: "A place where you can see animals.",
  },
  {
    word: "chair",
    hint: "Something you sit on.",
  },
  {
    word: "satr",
    hint: "A tiny light in the sky at night.",
  },
  {
    word: "rainbow",
    hint: "A colorful arc in the sky after rain.",
  },
  {
    word: "honeybee",
    hint: "A yellow and black insect that makes honey.",
  },
  {
    word: "fish",
    hint: "An animal that lives in water.",
  },
  {
    word: "butterfly",
    hint: "A colorful insect with wings.",
  },
  {
    word: "library",
    hint: "collection of books",
  },
];

const wordText = document.querySelector(".word"),
  hintText = document.querySelector(".hint span"),
  timeText = document.querySelector(".time b"),
  inputField = document.querySelector("input"),
  refreshBtn = document.querySelector(".refresh-word"),
  checkBtn = document.querySelector(".check-word");

let correctWord, timer;

// Function to initialize the timer
const initTimer = (maxTime) => {
  clearInterval(timer);
  timer = setInterval(() => {
    if (maxTime > 0) {
      maxTime--;
      return (timeText.innerText = maxTime);
    }
    alert(`Time off! ${correctWord.toUpperCase()} was the correct word`);
    initGame();
  }, 1000);
};

// Function to initialize the game
const initGame = () => {
  initTimer(30);
  let randomObj = words[Math.floor(Math.random() * words.length)];
  let wordArray = randomObj.word.split("");
  for (let i = wordArray.length - 1; i > 0; i--) {
    let j = Math.floor(Math.random() * (i + 1));
    [wordArray[i], wordArray[j]] = [wordArray[j], wordArray[i]];
  }
  wordText.innerText = wordArray.join("");
  hintText.innerText = randomObj.hint;
  correctWord = randomObj.word.toLowerCase();
  inputField.value = "";
  inputField.setAttribute("maxlength", correctWord.length);
};
initGame();

// Function to check the user's input word
const checkWord = () => {
  let userWord = inputField.value.toLowerCase();
  if (!userWord) return alert("Please enter the word to check!");
  if (userWord !== correctWord)
    return alert(`Oops! ${userWord} is not a correct word`);
  alert(`Congrats! ${correctWord.toUpperCase()} is the correct word`);
  initGame();
};

// Event listeners for the refresh and check buttons
refreshBtn.addEventListener("click", initGame);
checkBtn.addEventListener("click", checkWord);
