let questionCount = 1;

function addQuestion() {
    questionCount++;

    const container = document.getElementById("questions-container");
    
    let newQuestion = `
        <label for="question${questionCount}">Question ${questionCount}</label>
        <input type="text" name="questions[]" id="question${questionCount}" required>

        <label for="option${questionCount}a">Option A</label>
        <input type="text" name="options${questionCount}a" id="option${questionCount}a" required>

        <label for="option${questionCount}b">Option B</label>
        <input type="text" name="options${questionCount}b" id="option${questionCount}b" required>

        <label for="option${questionCount}c">Option C</label>
        <input type="text" name="options${questionCount}c" id="option${questionCount}c" required>

        <label for="option${questionCount}d">Option D</label>
        <input type="text" name="options${questionCount}d" id="option${questionCount}d" required>

        <label for="correct${questionCount}">Correct Option</label>
        <select name="correct[]" id="correct${questionCount}">
            <option value="a">A</option>
            <option value="b">B</option>
            <option value="c">C</option>
            <option value="d">D</option>
        </select>
    `;

    container.insertAdjacentHTML('beforeend', newQuestion);
}
