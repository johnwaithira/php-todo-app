const  togglepassword =  document.querySelector("#togglepassword");
            const  password =  document.querySelector("#password");
            togglepassword.style.position = "absolute";
            togglepassword.style.right = 50+"px";
            togglepassword.style.background = "none";
            togglepassword.style.fontSize = 27+"px";
            togglepassword.style.cursor = "pointer";
            togglepassword.style.color = "black";
           
            togglepassword.addEventListener('click', function(){
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.classList.toggle('bi-eye');

            });