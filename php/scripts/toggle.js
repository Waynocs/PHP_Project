        var news = document.querySelector('#news');
        var theme = document.querySelector('#theme');
        var langue = document.querySelector('#langue');

        var postArticle = document.querySelector('#postArticle');
        var postTheme = document.querySelector('#postTheme');
        var postLangue = document.querySelector('#postLangue');

        postTheme.style.display = 'none';
        postLangue.style.display = 'none';


        news.addEventListener('click', event => {
            if (postArticle.style.display == 'none') {
                postArticle.style.display = 'block';
                postTheme.style.display = 'none';
                postLangue.style.display = 'none';

                news.style.textDecoration = 'underline';
                theme.style.textDecoration = 'none';
                langue.style.textDecoration = 'none';
            }
        })

        theme.addEventListener('click', event => {
            if (postTheme.style.display == 'none') {
                postTheme.style.display = 'block';
                postLangue.style.display = 'none';
                postArticle.style.display = 'none';

                theme.style.textDecoration = 'underline';
                langue.style.textDecoration = 'none';
                news.style.textDecoration = 'none';
            }
        })

        langue.addEventListener('click', event => {
            if (postLangue.style.display == 'none') {
                postLangue.style.display = 'block';
                postTheme.style.display = 'none';
                postArticle.style.display = 'none';

                langue.style.textDecoration = 'underline';
                theme.style.textDecoration = 'none';
                news.style.textDecoration = 'none';
            }
        })