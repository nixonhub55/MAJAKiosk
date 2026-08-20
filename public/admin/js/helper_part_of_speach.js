function ShowHelps(){      

    var query = '<?=$result?>'.toLowerCase();  
    var org_res = query;
    query = query.trim(); 
    query = query.replace(/\s+/g, ' ').trim(); 


    const pronouns = {
                        personal: {
                            subject: ["I", "You", "He", "She", "It", "We", "They"],
                            object: ["Me", "You", "Him", "Her", "It", "Us", "Them","im"],
                            possessive: ["Mine", "Yours", "His", "Hers", "Its", "Ours", "Theirs"]
                        },
                        reflexive: ["Myself", "Yourself", "Himself", "Herself", "Itself", "Ourselves", "Yourselves", "Themselves"],
                        demonstrative: ["This", "That", "These", "Those"],
                        interrogative: ["Who", "What", "Which", "Whose"],
                        indefinite: ["Anyone", "Anything", "Each", "Everyone", "Everything", "Someone", "Somebody", "Something", "No one", "Nobody", "Nothing", "All", "Some", "Few", "Many", "Several", "Any"],
                        relative: ["Who", "Whom", "Which", "That", "Whose"],
                        reciprocal: ["Each other", "One another"],
                        possessiveAdjectives: ["My", "Your", "His", "Her", "Its", "Our", "Their"]
    };


    const verbs = {
                    regular: {
                        base: ["know","want","walk", "talk", "play", "work", "jump", "clean", "cook", "study", "watch"],
                        present: ["knowing","wanting","walking", "talking", "playing", "working", "jumping", "cleaning", "cooking", "studying", "watching"],
                        past: ["walked", "talked", "played", "worked", "jumped", "cleaned", "cooked", "studied", "watched"],
                        pastParticiple: ["walked", "talked", "played", "worked", "jumped", "cleaned", "cooked", "studied", "watched"]
                    },
                    irregular: {
                        base: ["go", "eat", "be", "have", "see", "do", "get", "take", "come", "give"],
                        present: ["going", "eating", "being", "having", "seing", "doing", "getting", "coming", "giving"],
                        past: ["went", "ate", "was/were", "had", "saw", "did", "got", "took", "came", "gave"],
                        pastParticiple: ["gone", "eaten", "been", "had", "seen", "done", "gotten", "taken", "come", "given"]
                    },
                    modal: ["can", "could", "will", "would", "shall", "should", "may", "might", "must","how"],
                    phrasal: {
                        base: ["get up", "turn off", "put on", "take off", "look after", "run out of", "give up"],
                        past: ["got up", "turned off", "put on", "took off", "looked after", "ran out of", "gave up"],
                        pastParticiple: ["gotten up", "turned off", "put on", "taken off", "looked after", "run out of", "given up"]
                    }
        };


    const prepositions = {
                    time: ["at", "on", "in", "before", "after", "during", "since", "for", "until", "by"],
                    place: ["at", "in", "on", "under", "over", "between", "next to", "behind", "in front of", "beside", "among"],
                    direction: ["to", "into", "onto", "from", "towards", "through", "across", "up", "down", "along"],
                    manner: ["by", "with", "like", "as", "in", "for"],
                    agent: ["by"],
                    cause: ["because of", "due to", "thanks to", "on account of"],
                    accompaniment: ["with", "without"],
                    instrument: ["with", "by"]
    };

    const conjunctions = {
                    coordinating: ["and", "but", "or", "nor", "for", "yet", "so"],
                    subordinating: ["although", "because", "since", "unless", "if", "while", "as", "before", "after", "even though", "until", "in case", "so that"],
                    correlative: ["either...or", "neither...nor", "not only...but also", "both...and", "whether...or"],
                    adverbial: ["therefore", "however", "thus", "meanwhile", "consequently", "moreover", "nevertheless"]
    };

    const others ={
    other1:["need","view"]
    };

    let words = query.split(" ");
    let allPronouns = [
                    ...pronouns.personal.subject,
                    ...pronouns.personal.object,
                    ...pronouns.personal.possessive,
                    ...pronouns.reflexive,
                    ...pronouns.demonstrative,
                    ...pronouns.interrogative,
                    ...pronouns.indefinite,
                    ...pronouns.relative,
                    ...pronouns.reciprocal,
                    ...pronouns.possessiveAdjectives
                ];

    let filProNouns = words.filter(word => 
    !allPronouns.some(pronoun => pronoun.toLowerCase() === word.toLowerCase())
    );

    query = filProNouns.join(" ");
    words = query.split(" ");

    let all_verbs = [
                    ...verbs.regular.base,
                    ...verbs.regular.present,
                    ...verbs.regular.past,
                    ...verbs.regular.pastParticiple,
                    ...verbs.irregular.base,
                    ...verbs.irregular.present,
                    ...verbs.irregular.past,
                    ...verbs.irregular.pastParticiple,
                    ...verbs.modal,
                    ...verbs.phrasal.base,
                    ...verbs.phrasal.past,
                    ...verbs.phrasal.pastParticiple,
                ];

    let filVerbs = words.filter(word => 
    !all_verbs.some(verb => verb.toLowerCase() === word.toLowerCase())
    );

    query = filVerbs.join(" ");
    words = query.split(" ");

    let allPrepositions = [
                    ...prepositions.time,
                    ...prepositions.place,
                    ...prepositions.direction,
                    ...prepositions.manner,
                    ...prepositions.agent,
                    ...prepositions.cause,
                    ...prepositions.accompaniment,
                    ...prepositions.instrument
                ];

    let filPrepositions = words.filter(word => 
    !allPrepositions.some(preposition => preposition.toLowerCase() === word.toLowerCase())
    );

    query = filPrepositions.join(" ");
    words = query.split(" ");

    let all_conjunctions = [
                    ...conjunctions.coordinating,
                    ...conjunctions.subordinating,
                    ...conjunctions.correlative,
                    ...conjunctions.adverbial
                ];

    let filConjunctions = words.filter(word => 
    !all_conjunctions.some(conjunction => conjunction.toLowerCase() === word.toLowerCase())
    );
    query = filConjunctions.join(" ");
    words = query.split(" ");

    let all_others = [
                    ...others.other1
                ];
    let filOthers = words.filter(word => 
    !all_others.some(other => other.toLowerCase() === word.toLowerCase())
    );

    query = filOthers.join(" ");
    words = query.split(" ");


    console.log(words);
    console.log(query);


    let contentDiv = document.getElementById("content");
    let divs = document.querySelectorAll(".container .divSearch");
    let results = []; 
    if (query === "") { 
        contentDiv.style.display = 'none';
        return;
    }

    query = query.split(" ");

    query.forEach(item => { 
        divs.forEach(function(div) {  
            
            var new_div_inner = div.innerHTML.toLowerCase();   
            if(new_div_inner.includes(item)){  
                if(new_div_inner.includes(item) && !results.includes(div.outerHTML)){
                    results.push(div.outerHTML); 
                }
            }
        });               
    });  
    contentDiv.innerHTML = "";
    const resultsDiv = document.getElementById("search-results"); 

    //alert(results.length);

    if (results.length > 0) { 
        contentDiv.innerHTML = results.join('<br>');
        } 
    else { 
        window.location.replace("/no_result_fround/"+org_res); 
    }   
    }


    ShowHelps();

    function SearchRelated(){  
        var query = document.getElementById('search-input').value.toLowerCase();   
        
         if(query==""){
            return false;
        } 
        window.location.replace("/search/"+query);  
    }
