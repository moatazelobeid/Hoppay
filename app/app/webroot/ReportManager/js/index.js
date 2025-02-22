// Copyright (c) 2012-2013 Luis E. S. Dias - www.smartbyte.com.br
//
// Permission is hereby granted, free of charge, to any person obtaining
// a copy of this software and associated documentation files (the
// "Software"), to deal in the Software without restriction, including
// without limitation the rights to use, copy, modify, merge, publish,
// distribute, sublicense, and/or sell copies of the Software, and to
// permit persons to whom the Software is furnished to do so, subject to
// the following conditions:
//
// The above copyright notice and this permission notice shall be
// included in all copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
// EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
// MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
// NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
// LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
// OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
// WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

$(document).ready(function() {
    $('#ReportManagerModel').change(function(){
        if ( $(this).val() != '' ) {
            $.ajax({
            type: "POST",
            url: firstLevel+"reports/ajaxGetOneToManyOptions",
            dataType: 'text',
            data: "model=" + $(this).val(),
            success: function(oneToManyOptions){
                $('#ReportManagerOneToManyOptionSelect').html(oneToManyOptions);
            },
            error: function(msg) { 
                $('#ReportManagerOneToManyOptionSelect').html('< Ajax Error >');
            }
            });    
        }        
    });    
    
    $('.deleteReport').click(function(){
        var report = $('#ReportManagerSavedReportOption').val();
        if ( report != '' && confirm('Are you sure you want to delete '+report+'?')) {
            $.ajax({
            type: "POST",
            url: firstLevel+"reports/deleteReport/"+report,
            dataType: 'text',
            success: function(reportList){
                $('#ReportManagerSavedReportOptionContainer').html(reportList);
            },
            error: function(msg) { 
                $('#ReportManagerSavedReportOptionContainer').html('< Ajax Error >');
            }
            });    
        }        
    });      
    
});