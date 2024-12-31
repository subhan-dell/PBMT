
let budgetData = {
    totalBudget: localStorage.getItem("totalBudget") ? parseFloat(localStorage.getItem("totalBudget")) : 0,
    totalExpenses: localStorage.getItem("totalExpenses") ? parseFloat(localStorage.getItem("totalExpenses")) : 0,
    budgetLeft: localStorage.getItem("budgetLeft") ? parseFloat(localStorage.getItem("budgetLeft")) : 0,
    expenses: localStorage.getItem("expenses") ? localStorage.getItem("expenses").split("||").map(item => {
        let [title, amount] = item.split(",");
        return { title: title, amount: parseFloat(amount) };
    }) : []
};


function updateUI() {
    document.getElementById('totalBudget').textContent = budgetData.totalBudget.toFixed(2);
    document.getElementById('totalExpenses').textContent = budgetData.totalExpenses.toFixed(2);
    document.getElementById('budgetLeft').textContent = budgetData.budgetLeft.toFixed(2);

   
    let tableBody = document.querySelector('.table-container tbody');
    tableBody.innerHTML = '';
    budgetData.expenses.forEach(function (expense, index) {
        let row = document.createElement('tr');
        row.innerHTML = `
            <td>${expense.title}</td>
            <td>${expense.amount.toFixed(2)}</td>
            <td><button class="remove-expense-btn" data-index="${index}">Remove</button></td>
        `;
        tableBody.appendChild(row);
    });
}


function updateLocalStorage() {
    localStorage.setItem("totalBudget", budgetData.totalBudget);
    localStorage.setItem("totalExpenses", budgetData.totalExpenses);
    localStorage.setItem("budgetLeft", budgetData.budgetLeft);
    localStorage.setItem("expenses", budgetData.expenses.map(exp => `${exp.title},${exp.amount}`).join("||"));
}

function resetAll() {
  
    budgetData.totalBudget = 0;
    budgetData.totalExpenses = 0;
    budgetData.budgetLeft = 0;
    budgetData.expenses = [];

   
    updateLocalStorage();
    updateUI();
}

document.addEventListener("DOMContentLoaded", function () {
    
    updateUI();

  
    document.getElementById('addBudgetBtn').addEventListener('click', function (event) {
        event.preventDefault();
        let budgetInput = document.getElementById('budget');
        let budgetAmount = parseFloat(budgetInput.value.trim());

        if (isNaN(budgetAmount) || budgetAmount <= 0) {
            alert('Please enter a valid budget amount.');
            return;
        }

        budgetData.totalBudget = budgetAmount;
        budgetData.budgetLeft = budgetAmount - budgetData.totalExpenses;
        updateLocalStorage();
        updateUI();
        budgetInput.value = '';
    });

  
    document.getElementById('addExpenseBtn').addEventListener('click', function (event) {
        event.preventDefault();
        let expenseInput = document.getElementById('expense');
        let amountInput = document.getElementById('amount');

        let expenseTitle = expenseInput.value.trim();
        let expenseAmount = parseFloat(amountInput.value.trim());

        if (expenseTitle === '' || isNaN(expenseAmount) || expenseAmount <= 0) {
            alert('Please enter a valid expense.');
            return;
        }

     
        budgetData.expenses.push({
            title: expenseTitle,
            amount: expenseAmount
        });

      
        budgetData.totalExpenses += expenseAmount;
        budgetData.budgetLeft = budgetData.totalBudget - budgetData.totalExpenses;

        updateLocalStorage();
        updateUI();

    
        expenseInput.value = '';
        amountInput.value = '';
    });

    document.querySelector('.table-container').addEventListener('click', function (event) {
        if (event.target && event.target.matches("button.remove-expense-btn")) {
            let index = event.target.getAttribute('data-index');
            let removedExpense = budgetData.expenses.splice(index, 1)[0];
            budgetData.totalExpenses -= removedExpense.amount;
            budgetData.budgetLeft += removedExpense.amount;
            updateLocalStorage();
            updateUI();
        }
    });

    document.getElementById('resetBtn').addEventListener('click', resetAll);
});
