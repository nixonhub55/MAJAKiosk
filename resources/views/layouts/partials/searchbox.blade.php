

        <?php

            $newId = bin2hex(random_bytes(32)); // 64-char secure token
            $newId2 = bin2hex(random_bytes(32)); // 64-char secure token
                
        ?>

        <script>
            var txtId = '<?= $newId ?>';
            var resuldId = '<?= $newId2 ?>';
 
        </script>

        <div class="input-group me-3" style="margin-left:20px;">
            <input type="text" class="form-control search"  id="<?= $newId ?>" onkeydown="return searchQuery('{{$newId}}','{{$newId2}}')" placeholder="Can I help you?" autocomplete="off">
            <button class="btn btn-secondary" type="button" >
                <i class="fas fa-search" type="button" onclick="return SearchRelated()"></i>
            </button>
             <ul id="<?= $newId2 ?>" class="list-group" style="position:absolute; z-index:999999; margin-top:35px"></ul> 
        </div>

   


        <script>

        var content = [];
        var num =0; 
        var tempDiv = document.createElement('div'); 
        
        
                
                 
        
        function LoadPageIntoDiv(php_page,this_element){
        
            var xhr = new XMLHttpRequest();
            xhr.open('GET', php_page, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {  
                tempDiv.innerHTML = xhr.responseText;
                
                var contentPElements = tempDiv.getElementsByClassName('content_p'); 
                
                    for (var i = 0; i < contentPElements.length; i++) {  
                        result=contentPElements[i].innerHTML;
                        var parentDiv = contentPElements[i].parentElement; 
                        var onclickFunction = parentDiv.getAttribute('onclick');
                        content.push({
                                        item: {
                                        lbl: result,
                                        fnctn: onclickFunction
                                        }
                                    });  
                    }   
                }
            };
            xhr.send();
        }

        LoadPageIntoDiv('{{url("/search/a")}}',this.resuldId);
           
        function updateSearchResults(query) { 
                    console.log(query);
                    const resultsDiv = document.getElementById(this.resuldId); 
                    resultsDiv.innerHTML = '';  

                    if (query.trim() === '') {
                        resultsDiv.style.display = 'none';  
                        return;
                    }
 
                    const filteredResults = content.filter(item => item.item.lbl.toLowerCase().includes(query.toLowerCase()));
                    
                    if (filteredResults.length > 0) {
                        resultsDiv.style.display = 'block'; 
                        filteredResults.forEach(result => {
                            const resultItem = document.createElement("li");
                            resultItem.classList.add("list-group-item", "list-group-item-action");
                            resultItem.textContent = result.item.lbl;  
                            resultItem.addEventListener("click", function() {
                               eval(result.item.fnctn);
                            }); 
                            resultsDiv.appendChild(resultItem);
                        });
                    } else {
                        resultsDiv.style.display = 'block';  // Show the "no results" message 
                        const noResultsItem = document.createElement("li");
                        noResultsItem.classList.add("list-group-item", "list-group-item-action", "text-muted","cursor-pointer");
                        noResultsItem.textContent = "No results found";
                        resultsDiv.appendChild(noResultsItem);
                    }
                }

   // document.getElementsByClassName()  search
        
    /* document.getElementById(this.txtId).addEventListener("input", function() {
    //document.getElementsByClassName("search")[0].addEventListener("input", function() {
        var searchQuery = this.value.trim();   
                    searchQuery=ReplaceString(searchQuery,rplc1.monitoring);  
                    searchQuery=ReplaceString(searchQuery,rplc1.creating);  
                    searchQuery=ReplaceString(searchQuery,rplc1.modifying);  
                    searchQuery=ReplaceString(searchQuery,rplc1.accepting);  
                    searchQuery=ReplaceString(searchQuery,rplc1.rejecting);
                    searchQuery=ReplaceString(searchQuery,rplc1.cancelling); 
                    searchQuery=ReplaceString(searchQuery,rplc1.access); 
                    searchQuery=ReplaceString(searchQuery,rplc1.forgot); 
                    searchQuery=ReplaceString(searchQuery,rplc1.retrive);
                    searchQuery=ReplaceString(searchQuery,rplc1.time);
                    updateSearchResults(searchQuery); 
        });  
 */

   /*  document.querySelectorAll(".search").forEach(el => {
        el.addEventListener("input", function() {
             var searchQuery = this.value.trim();   
                  searchQuery=ReplaceString(searchQuery,rplc1.monitoring);  
                  searchQuery=ReplaceString(searchQuery,rplc1.creating);  
                  searchQuery=ReplaceString(searchQuery,rplc1.modifying);  
                  searchQuery=ReplaceString(searchQuery,rplc1.accepting);  
                  searchQuery=ReplaceString(searchQuery,rplc1.rejecting);
                  searchQuery=ReplaceString(searchQuery,rplc1.cancelling); 
                  searchQuery=ReplaceString(searchQuery,rplc1.access); 
                  searchQuery=ReplaceString(searchQuery,rplc1.forgot); 
                  searchQuery=ReplaceString(searchQuery,rplc1.retrive);
                  searchQuery=ReplaceString(searchQuery,rplc1.time);
                  updateSearchResults(searchQuery); 
        });
    }); */

       
 
        function go_to_page(this_page) {   
            
            let parts = this_page.split('/'); 
            let base = parts[0]; // 'web_helper'
            let param = parts[1]; // 'div_dashboard' 
            window.location.href = "{{ url('/') }}/" + base + '/' + param;
        }
            
        function SearchRelated(){  
            var query = document.getElementById(this.this.txtId).value.toLowerCase();   
            if(query==""){
                return false;
            }


            var query = document.getElementById(this.this.txtId).value.toLowerCase();   
            window.location.replace("/search/"+query); 
        }

 
        
    </script>