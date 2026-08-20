        <div class="input-group me-3">
            <input type="text" class="form-control search" id="search-input" placeholder="Can I help you?" autocomplete="off">
            <button class="btn btn-secondary" type="button" >
                <i class="fas fa-search" type="button" onclick="return SearchRelated()"></i>
            </button>
            <ul id="search-results" class="list-group mt-1" style="display: none;"></ul>
        </div>


        <script>

        var content = [];
        var num =0; 
        var tempDiv = document.createElement('div'); 
        
        const rplc1 = {
                monitoring:["check","view","manage","track","monitor","inspect","Examine","Review","Verify","Scrutinize","Confirm","Look over","Investigate","Survey"].map(item => item.toLowerCase()),
                creating:["create","add","Make","Compose","Insert","Submit","File","Input","Register","Request","Send"].map(item => item.toLowerCase()),
                modifying:["update","delete","remove","modify","update","change","edit"].map(item => item.toLowerCase()),
                accepting:["approve","accept","Authorize","Validate","Confirm","Agree","Allow","Grant"].map(item => item.toLowerCase()),
                rejecting:["reject","Decline","Refuse","Deny","Disapprove","Exclude","Discard","Ignore"].map(item => item.toLowerCase()),
                cancelling:["discard","cancel","Abort","Revoke","unsend","Undo","Stop","Discontinue","Void"].map(item => item.toLowerCase()),
                access:["access","access","login","user","username"].map(item => item.toLowerCase()),
                forgot:["forgot","forgot","forget"].map(item => item.toLowerCase()),
                retrive:["retrive","retrive","recover","back","get","find"].map(item => item.toLowerCase()),
                time:["calendar","schedule","dates"].map(item => item.toLowerCase())
                }; 
                
                 
        
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

        LoadPageIntoDiv('{{url("/search/a")}}','search-results');
           
        function updateSearchResults(query) { 
                    console.log(query);
                    var resultsDiv = document.getElementById("search-results"); 
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
        
    document.getElementById("search-input").addEventListener("input", function() {
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

        function ReplaceString(searchQuery,rplc1){ 
            rplc1.forEach(word => {
            if (searchQuery.includes(word)) {  
                searchQuery = searchQuery.replace(word, rplc1[0]);
            }
            }); 
            return searchQuery;
        }
 
        function go_to_page(this_page) {   
            
            let parts = this_page.split('/'); 
            let base = parts[0]; // 'web_helper'
            let param = parts[1]; // 'div_dashboard' 
            window.location.href = "{{ url('/') }}/" + base + '/' + param;
        }
            
        function SearchRelated(){  
            var query = document.getElementById('search-input').value.toLowerCase();   
            if(query==""){
                return false;
            }


            var query = document.getElementById('search-input').value.toLowerCase();   
            window.location.replace("/search/"+query); 
        }

 
        
    </script>