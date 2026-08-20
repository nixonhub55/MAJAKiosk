
var rplc1 = {
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

 function ReplaceString(searchQuery,rplc1){ 
            rplc1.forEach(word => {
            if (searchQuery.includes(word)) {  
                searchQuery = searchQuery.replace(word, rplc1[0]);
            }
            }); 
            return searchQuery;
        }

function searchQuery(searchID,resultId){ 
        var searchQuery = document.getElementById(searchID).value.trim();   
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
        updateSearchResults2(searchQuery,resultId);

}

function updateSearchResults2(query,resultId) { 
    console.log(query);
    var resultsDiv = document.getElementById(resultId); 
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
        //resultsDiv.style.display = 'block';  // Show the "no results" message 
        const noResultsItem = document.createElement("li");
         noResultsItem.classList.add("list-group-item", "list-group-item-action", "text-muted","cursor-pointer");
        noResultsItem.textContent = "No results found";
        resultsDiv.appendChild(noResultsItem);
    }
}