document.addEventListener("DOMContentLoaded", function () {
    // Toggle sub-categories
    var categories = document.querySelectorAll('.category');

    categories.forEach(function (category) {
        category.addEventListener('click', function (event) {
            var subCategory = category.querySelector('.sub-category');
            console.log("Clicked!");
            if (subCategory) {
                if (subCategory.classList.contains('show')) {
                    subCategory.classList.remove('show');
                } else {
                    subCategory.classList.add('show');
                }
                event.preventDefault();
            }
        });
    });
});
