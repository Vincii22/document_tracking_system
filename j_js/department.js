$(document).ready(function () {
    var selected,selectedCode;
    loadDeptData(1);
    loadHeads();
    

    $("#addSave").click(function() {
        console.log('Joel');
        saveDept();
      });
    
    $("#editSave").click(function() {
        updateDept(selected);
      });
    
    $("#tableArea").on( "click", ".btn-primary",function() {
        selected=$(this).parent().parent().data('id');
        loadSelectedDept($(this).parent().parent().data('id'));
      });

    $("body").on( "click", ".btn-success",function() {
        $("select").val("");
      });
    
    //delete script
    $("#tableArea").on( "click", ".btn-danger",function() {
        selected=$(this).parent().parent().data('id');
        
        selectedCode=($(this).parent().prev().prev().text());

        if (confirm("Are you sure you want to delete "+selectedCode+"?")) {
            deleteDept(selected);
        } else {
            //txt = "You pressed Cancel!";
        }
      });

    $("#tableArea").on( "click", ".page-item",function() {
        console.log($(this).data('value'));
        loadDeptData($(this).data('value'));
      });


});

function loadDeptData(pagenum){
    $.get("../../j_php/retrieve_departments.php",{
        page: pagenum,
        },
        successFn,
        "text");
}



function successFn(result){
    $('#tableArea').html(result);    
}


//loads the user accounts of the management
function loadHeads(){
    $.get("../../j_php/retrieve_heads.php", function(data){
            $('optgroup').html(data);
            }
        );
    
    }  
    
function saveDept(){

    $.get("../../j_php/department_add.php",{
        dname: $("#deptName").val(),
        dcode: $("#deptCode").val(),
        dhead: $("#deptHeadAdd").val()
        }, 
        function(data){
            if(data==1){
                
                alert($("#deptName").val()+' department was successfully created');
                location.reload();
                }
            else
                alert('Something went wrong!');
            
            }
        );
   
    } 

function updateDept(deptid){

        $.get("../../j_php/department_update.php",{
            deptid: deptid,
            depthead: $("#deptHeadEdit").val(),
            }, 
            function(data){
                if(data==1){
                    alert('Department was successfully updated');
                    location.reload();
                    }
                else
                    alert('Something went wrong!');
                
                }
            );
       
        } 

function loadSelectedDept(deptid){
    $.get("../../j_php/department_retrieve.php",{
        dept_id: deptid,
        }, 
         function(data){
            var r = JSON.parse(data);
            $("#deptLabel").text(r.dcode);
            $("#deptHeadEdit").val(r.dhead);
            }
        );
    }

function deleteDept(deptid){
    $.get("../../j_php/department_delete.php",{
        dept_id: deptid,
        }, 
         function(data){
            if(data=1) {
                alert("Deparment was successfully deleted!");
                location.reload();
            }
            else {
                alert("Something went wrong!");
                location.reload();
            }   
        }
    );
}




  



