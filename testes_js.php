

<!DOCTYPE html>
<html>
<head lang="pt">

</head>
<body>
<h2>Testes</h2>
    <div class="parent">
        <div style="width:500px;">Parent
        <ul id= "lista1">
            <li id="one" onover="changeStyle()"><span>I am the first one</span>
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
        
        $(document).ready(function(){
            $("#one").hover(function(){
                $(this).css("background","#00CED1");
            },
            function(){
                $(this).css("background", "none");
            });
        });

        // on Hover change id="one" background-color with JS
        const ele = document.getElementById('two');
        ele.addEventListener('mouseover',function handleMouseOver(){
            ele.style.backgroundColor = '#87CEFA';
        });
        ele.addEventListener('mouseout', function handleMouseOut(){
            ele.style.backgroundColor ="transparent";
        });
       
    </script>
</body>
</html>
