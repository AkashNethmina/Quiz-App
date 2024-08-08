<template>
    <Layout>
      <button @click="createQuestion" class="btn btn-success main-succ">Create</button>
      <DataTable
                :columns="columns"
                :data="questions"
                class="table table-hover table-striped table-bordered text-center"
                width="100%"
            >
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Question</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Question</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Action</th>
                    </tr>
                </tfoot>
            </DataTable>





      <Teleport to="body">
        <NewQuestionModal :show="showNewQuestionModal" @close="destroyModal">
          <template #header>
            <h5>Add New Question</h5>
          </template>
          <template #success>
            <div v-if="success" class="alert alert-success">{{ success }}</div>
          </template>
          <template #body>
            <form>
              <div class="mb-3">
                <label for="questionInput" class="form-label">Question</label>
                <input type="text" v-model="createdQuestion" class="form-control" id="questionInput">
              </div>
              <div class="mb-3">
                <label for="questionType" class="form-label">Question Type</label>
                <select v-model="questionType" class="form-select" id="questionType" @change="resetForm">
                  <option value="MCQ">Multiple Choice</option>
                  <option value="True/False">True/False</option>
                </select>
              </div>
              <table class="table" v-if="questionType === 'MCQ'">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Answers</th>
                    <th scope="col">Correct ?</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(answer, index) in newAnswers" :key="index">
                    <th scope="row">{{ answer.id }}</th>
                    <td>
                      <input type="text" v-model="answer.answer" class="form-control">
                    </td>
                    <td>
                      <input :checked="answer.correct_answer === 1" class="form-check-input" :value="answer.id" @change="handleRadioToggle(answer.id)" type="radio">
                    </td>
                  </tr>
                </tbody>
              </table>
              <div v-if="questionType === 'True/False'">
                <label class="form-label">Answers</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" v-model="newAnswers[0].correct_answer" :value="true">
                  <label class="form-check-label">True</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" v-model="newAnswers[0].correct_answer" :value="false">
                  <label class="form-check-label">False</label>
                </div>
              </div>
            </form>
          </template>
          <template #footer>
            <span @click="addNewAnswer" v-if="questionType === 'MCQ' && newAnswers.length < 4"><h3>+</h3></span>
            <button @click="destroyModal" class="btn btn-danger">Close</button>
            <button v-if="(questionType === 'MCQ' && newAnswers.length >= 2) || (questionType === 'True/False' && newAnswers.length === 2)" @click="submitQuestion" class="btn btn-primary main-left">Submit</button>
          </template>
        </NewQuestionModal>

        <NewQuestionModal :show="showViewQuestionModal" @close="destroyModal">
          <template #header>
            <h5>View Question</h5>
          </template>
          <template #success>
            <div v-if="success" class="alert alert-success">{{ success }}</div>
          </template>
          <template #body>
            <h3>{{ selectedQuestion?.question }}</h3>
            <form>
              <table class="table" v-if="selectedQuestion?.type === 'MCQ'">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Answers</th>
                    <th scope="col">Correct ?</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(answer, index) in answers" :key="index">
                    <th scope="row">{{ answer.id }}</th>
                    <td>
                      <input type="text" v-model="answer.answer" class="form-control">
                    </td>
                    <td>
                      <input :checked="answer.correct_answer === 1" class="form-check-input" :value="answer.id" @change="handleRadioChange(answer.id)" type="radio">
                    </td>
                  </tr>
                </tbody>
              </table>
              <div v-if="selectedQuestion?.type === 'True/False'">
                <label class="form-label">Answers</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" v-model="answers[0].correct_answer" :value="1">
                  <label class="form-check-label">True</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" v-model="answers[0].correct_answer" :value="0">
                  <label class="form-check-label">False</label>
                </div>
              </div>
            </form>
          </template>
          <template #footer>
            <button @click="destroyModal" class="btn btn-danger">Close</button>
            <button @click="updateAnswers" class="btn btn-primary main-left">Update</button>
          </template>
        </NewQuestionModal>

        <NewQuestionModal :show="editquestionModal" @click="aditQuestionModal=false">
          <template #header>
            <h5>Edit Question</h5>
          </template>
          <template #success>
            <div v-if="success" class="alert alert-success">{{ success }}</div>
          </template>
          <template #body>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Question</label>
              <input v-model="questionForEdit.question" type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
            </div>
          </template>
          <template #footer>
            <button @click="editquestionModal=false" class="btn btn-danger">Close</button>
            <button @click="updateQuestion" class="btn btn-success main-left">Update</button>
          </template>
        </NewQuestionModal>
      </Teleport>
    </Layout>
  </template>


<script setup>

import Layout from "@/Shared/Admin/Layout.vue";
import NewQuestionModal from '@/Shared/NewQuestionModal.vue';
import { router } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net-bs5";

// Reactive references and computed properties
const page = usePage();
const success = computed(() => page.props.flash.success);
const showNewQuestionModal = ref(false);
const showViewQuestionModal = ref(false);
const createdQuestion = ref('');
const newAnswers = ref([]);
const answers = ref([]);
const selectedAnswer = ref(null);
const selectedQuestion = ref(null);
const questionType = ref('MCQ');
let answerId = 1;

// Function to create a new question
function createQuestion() {
    showNewQuestionModal.value = true;
    resetForm();
}

// Function to reset form fields
function resetForm() {
    createdQuestion.value = '';
    newAnswers.value = [];
    selectedAnswer.value = null;
    if (questionType.value === 'True/False') {
        newAnswers.value = [
            { id: answerId++, answer: 'True', correct_answer: 0 },
            { id: answerId++, answer: 'False', correct_answer: 0 }
        ];
    }
}

// Function to close the modal
function destroyModal() {
    showNewQuestionModal.value = false;
    showViewQuestionModal.value = false;
    editquestionModal.value = false;
    resetForm();
}

// Function to add a new answer for MCQ type questions
function addNewAnswer() {
    if (questionType.value === 'MCQ') {
        const newAnswer = {
            id: answerId++,
            answer: '',
            correct_answer: 0
        };
        newAnswers.value.push(newAnswer);
    }
}

// Function to handle radio button toggle
function handleRadioToggle(Id) {
    selectedAnswer.value = Id;
    newAnswers.value.forEach(answer => {
        answer.correct_answer = (answer.id === Id) ? 1 : 0;
    });
}

// Function to validate answers
function validateAnswers() {
    for (const answer of newAnswers.value) {
        if (answer.answer.trim() === '') {
            return false;
        }
    }
    return true;
}

// Function to validate answer count
function answerCount() {
    if (newAnswers.value.length < 2 && questionType.value === 'MCQ') {
        alert('At least two answers are required to submit');
        return false;
    } else if (newAnswers.value.length !== 2 && questionType.value === 'True/False') {
        alert('Two answers are required for True/False questions');
        return false;
    }
    return true;
}

// Function to submit a new question
async function submitQuestion() {
    if (!createdQuestion.value) {
        alert('Question cannot be empty');
        return;
    }

    if (!validateAnswers() || !answerCount()) {
        alert('Fill all inputs before submitting');
        return;
    }

    try {
        await router.post('/admin/questions', {
            question: createdQuestion.value,
            answers: newAnswers.value,
            type: questionType.value
        });

        resetForm();
        showNewQuestionModal.value = false;
    } catch (error) {
        console.error(error);
    }
}

// Define properties for the component
const props = defineProps({
    questions: Array,
    errors: Object,
});

// Function to view a selected question
function viewQuestion(index) {
    showViewQuestionModal.value = true;
    selectedQuestion.value = props.questions[index];
    answers.value = props.questions[index].answers;
}

// Function to handle radio button change for editing answers
const selectedEditAnswer = ref(null);
function handleRadioChange(Id) {
    selectedEditAnswer.value = Id;
    answers.value.forEach(answer => {
        answer.correct_answer = (answer.id === Id) ? 1 : 0;
    });
}

// Function to update answers
async function updateAnswers() {
  try {
    const answerId = answers.value[0].id; // Adjust based on your data structure
    await axios.put(`/admin/answers/${answerId}`, { answers: answers.value });
    alert('Answers updated');
    showViewQuestionModal.value = false;
  } catch (error) {
    console.error(error);
    alert('Failed to update answers');
  }
}

// Edit question functionality
const editquestionModal = ref(false)
const questionForEdit = ref(null)

function editQuestion(index) {
  questionForEdit.value = props.questions[index];
  //alert(index)
  editquestionModal.value = true;
}

// Function to update a question
function updateQuestion() {
    
   router.put('/admin/questions', questionForEdit.value)
}


// Function to delete a question
async function deleteQuestion(id) {
  if (confirm('You are about to delete a record, are you sure?')) {
      try {
          await router.get('/admin/questions/' + id);
      } catch (error) {
          console.error(error);
          alert('Failed to delete question');
      }
  }
}


DataTable.use(DataTablesCore);

const columns = [
    { data: "id", title: "#", className: "text-center" },
    { data: "question", title: "Question", className: "text-center" },
    { data: "type", title: "Type", className: "text-center" },
    {
    title: 'Actions',  // Action column header
    data: null,       // No data binding, we'll use custom rendering
    orderable: false, // Disable sorting on this column
    className: 'text-center',
   
    render(data, type, row, meta) {
      return `
    <button class="btn btn-primary" data-action="view" data-index="${meta.row}">View</button>
    <button class="btn btn-success main-left" data-action="edit" data-index="${meta.row}">Edit</button>
    <button class="btn btn-danger main-left" data-action="delete" data-id="${data.id}">Delete</button>
  `;
    }}
];

function handleAction(event) {
  const action = event.target.getAttribute('data-action');
  const index = event.target.getAttribute('data-index');
  const id = event.target.getAttribute('data-id');

  if (action === 'view') {
    viewQuestion(index);
  } else if (action === 'edit') {
    editQuestion(index);
  } else if (action === 'delete') {
    deleteQuestion(id);
  }
}
// Initialize the DataTable and attach the event listener
onMounted(() => {
  const tableElement = document.querySelector('.table');
  tableElement.addEventListener('click', handleAction);
});



</script>


  <style scoped>

  @import 'bootstrap';
  @import 'datatables.net-bs5';
  .main-succ {
    margin-bottom: 20px;
  }

  .main-left {
    margin-left: 10px;
  }



.table td, .table th {
  text-align: center;
}
.table-bordered th, .table-bordered td {
  border: 1px solid #dee2e6; /* Customize the border color */
}

.table-hover tbody tr:hover {
  background-color: #f8f9fa; /* Customize the hover background color */
}

  </style>