



<!DOCTYPE html>
<html>
<head lang="pt">

</head>
<body>
<h2>Testes</h2>
    <div class="parent">
        <div style="width:500px;">Parent
        <ul id= "lista1">
            <li id="one"><span>I am the first one</span>
            </li>
            <li id="two">Second
            </li>
            <li id="three">Third
            </li>
            <li id="four">Fourth
            </li>
        </ul>
    </div>
    </div>
    <div class="tabela">
        <table id="table">
            <tr>
                <th id="Company">Company</th>
                <th id="Contact">Contact</th>
                <th id="Country">Country</th>
            </tr>
            <tr>
                <td>Ideias</td>
                <td>Boss</td>
                <td>Portugal</td>
            </tr>
            </table>
    </div>

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
 <script>
        $("h2").css({"background-color": "#66CDAA", "font-size": "3rem", "width": "50%", "text-align":"center"});
        $("#lista1").css({"border": "1px solid green","width": "143%", });
        /* $(document).ready(function(){
            $("span".parent().css({"color": "red", "border": "1px solid red"}));
        }); */

        // on Hover change id="one" background-color with JQUERY
        
    /*     $(document).ready(function(){
            $("#one").hover(function(){
                $(this).css("background","#00CED1");
            },
            function(){
                $(this).css("background", "none");
            });
        }); */

        // on Hover change id="one" background-color with JS
       /*  const ele = document.getElementById('two');
        ele.addEventListener('mouseover',function handleMouseOver(){
            ele.style.backgroundColor = '#87CEFA';
        });
        ele.addEventListener('mouseout', function handleMouseOut(){
            ele.style.backgroundColor ="transparent";
        }); */
        /* let listItems = document.querySelectorAll('li');
            console.log(listItems);
            // for(let i=0;i<listItems.length;i++){//n esquecer declarar i
                
                listItems[i].addEventListener('mouseover', function handleMouseOver(){
                    listItems[i].style.backgroundColor = '#87CEFA';
                });
                listItems[i].addEventListener('mouseout', function handleMouseOut(){
                    listItems[i].style.backgroundColor = 'transparent';
                });
            //} 
            listItems.forEach(function callback(item, index) { //use the spread operator to convert it into an array:
                item.addEventListener('mouseover', function handleMouseOver(){
                    
                    let thisPos = (index + 1) * 10;
                    let red = (Math.random() * (200 - 100));
                    let green = (Math.random() * (200 - 100));
                    let blue = (Math.random() * (200 - 100));
                    item.style.backgroundColor = 'rgb(' + red + ', ' + green + ', ' + blue + ')';
                   
                });
                item.addEventListener('mouseout', function handleMouseOut(){
                    item.style.backgroundColor = 'transparent';
                });

            }); */
        let listItems = document.querySelectorAll('li');
            console.log(listItems);
            listItems.forEach(function callback(item, index) { //use the spread operator to convert it into an array:
                item.addEventListener('mouseover', function handleMouseOver(){
                    /* const randColor = () =>  {
                        let min = 1000;
                        let max =  167777215;
                        let randVal = Math.random() * (max - min) + min;
                        return "#" + Math.floor(randVal).toString(16).padStart(6, '0').toUpperCase();
                        } */
                        const randColor = () =>  {
                        let min = 50;
                        let max = 245;
                        let red = Math.random() * (max - min) + min;
                        let green = Math.random() * (max - min) + min;
                        let blue = Math.random() * (max - min) + min;
                        return 'rgb(' + red + ', ' + green + ', ' + blue + ')';
                        }
                    item.style.backgroundColor = randColor();
                    //let color_checker = "";
                    
                    /* do{
                        color_checker=randColor();
                    }while(color_checker=="" || color_checker =="#000000" || color_checker == "#ffffff")*/
                    
                    //item.style.backgroundColor = color_checker;
                    //console.log(color_checker); 
                });
                item.addEventListener('mouseout', function handleMouseOut(){
                    item.style.backgroundColor = 'transparent';/*  */
                });
            });        
    </script>
</body>
