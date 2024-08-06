<template>
    <Layout>
        <!-- Display current question index and total questions -->
        <div v-if="!showNameInput" class="d-flex justify-content-center">
            Question {{ currentIndex + 1 }} out of {{ totalQuestions }}
        </div>
        <!-- Display time left for the current question -->
        <div v-if="!showNameInput" class="d-flex justify-content-center">
            <span>Time Left: {{ formattedTime }}</span>
        </div>
        <!-- Question and Answer List -->
        <div v-if="!showNameInput" class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <h6 class="mb-0">{{ currentQuestion.question }}</h6>
                        </div>
                    </div>
                </a>
                <a @click="selectedOption(index)" v-for="(answer, index) in answers" 
                   :class="{'selected': index === selectedAnswer}" 
                   class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <p class="mb-0 opacity-75">{{ answer.answer }}</p>
                        </div>
                    </div>
                </a>
                <div>
                    <!-- Show "Next" button if it's not the last question -->
                    <button @click="nextQuestion" v-if="!isLastQuestion" class="btn btn-primary">Next</button>
                    <!-- Show "Submit" button if it's the last question -->
                    <button @click="calculateResult" v-if="isLastQuestion" class="btn btn-success">Submit</button>
                </div>
            </div>
        </div>
        <!-- Name input field for submitting the results -->
        <div v-if="showNameInput" class="d-flex justify-content-center flex-column align-items-center">
            <input type="text" v-model="playerName" placeholder="Enter your name" class="form-control mb-2"  />
            <button @click="submitResults" class="btn btn-success">Submit Results</button>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '@/Shared/Layout.vue';
import { router } from '@inertiajs/vue3';
import { ref, computed, onMounted, watch } from 'vue';

const props = defineProps({
    questions: Array,
});

// State variables
const currentIndex = ref(0);
const totalQuestions = computed(() => props.questions.length);
const currentQuestion = computed(() => props.questions[currentIndex.value]);
const isLastQuestion = computed(() => currentIndex.value === props.questions.length - 1);
const answers = computed(() => props.questions[currentIndex.value].answers);
const selectedAnswer = ref(null);
const result = ref(0);
const negativeMarking = ref(0); // negative marks
const timePerQuestion = 30; // 30 seconds per question
const totalTime = ref(timePerQuestion * props.questions.length); // total quiz time
const timeRemaining = ref(timePerQuestion); // reset timer for each question
const playerName = ref('');
const showNameInput = ref(false);
const timer = ref(null);
const questionTimes = ref([]); // Store time taken for each question

// Compute formatted time for display
const formattedTime = computed(() => {
    const minutes = Math.floor(timeRemaining.value / 60);
    const seconds = timeRemaining.value % 60;
    return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
});

// Handle selecting an option
function selectedOption(index) {
    selectedAnswer.value = index;
}

// Move to the next question and track time taken
function nextQuestion() {
    if (selectedAnswer.value !== null) {
        if (props.questions[currentIndex.value].answers[selectedAnswer.value].correct_answer == 1) {
            result.value++;
        } else {
            negativeMarking.value++;
        }
    }
    // Record time taken for current question
    questionTimes.value[currentIndex.value] = timePerQuestion - timeRemaining.value;

    if (currentIndex.value < totalQuestions.value - 1) {
        currentIndex.value++;
        selectedAnswer.value = null;
        resetTimer();
    } else {
        calculateResult();
    }
}

// Calculate final results
function calculateResult() {
    if (selectedAnswer.value !== null) {
        if (props.questions[currentIndex.value].answers[selectedAnswer.value].correct_answer == 1) {
            result.value++;
        } else {
            negativeMarking.value++;
        }
    }

    // Record time for last question
    questionTimes.value[currentIndex.value] = timePerQuestion - timeRemaining.value;

    clearInterval(timer.value);
    showNameInput.value = true;
}

// Submit results including time taken for each question
function submitResults() {
    const finalScore = result.value - negativeMarking.value;
    const totalTimeTaken = questionTimes.value.reduce((acc, curr) => acc + curr, 0); // Sum of all question times

    // Post results to server
    router.post('/results', {
        results: {
            name: playerName.value,
            score: finalScore, // Final score based on correct answers and negative marking
            totalQuestions: totalQuestions.value,
            timeTaken: totalTimeTaken,
            questionTimes: questionTimes.value, // Include time taken per question
        },
    });
}

// Reset timer for the next question
function resetTimer() {
    timeRemaining.value = timePerQuestion;
}

// Start countdown timer for each question
function startTimer() {
    timer.value = setInterval(() => {
        if (timeRemaining.value > 0) {
            timeRemaining.value--;
        } else {
            nextQuestion();
        }
    }, 1000);
}

// Initialize timer on component mount
onMounted(() => {
    startTimer();
});

// Watch for changes in currentIndex to reset the timer
watch(currentIndex, () => {
    resetTimer();
});
</script>

<style scoped>
.selected {
    background-color: green;
    color: white;
}
</style>
