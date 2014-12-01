  
               
  <div class="wrapper">
                    <div class="rowpanel3 leftpatern_MrT new_tag3" style="text-align:center;min-height:500px;">
                    <div class="merchantlist fourtag">
                    	<h1><?=$menu_data['Menu_lang'][0]['menu_title']?></h1>
                        
                        <h4>
                       	<?=htmlspecialchars_decode($page_data['Page_lang'][0]['pg_descriptions'])?>
                    	</h4>
                    </div>
                    
                    
                  
                    
                    <div class="clear" style="height:15px;"></div>
                    <div class="shadow2">&nbsp;</div>
                    <div class="clear" style="height:15px;"></div>
                    
                    
                    <div id="accordion" class="merchanttabdata">
                                
                                  <!--  2nd tab start  -->
                                   
                                  <div id="two">
                                        <h3>
                                            <a href="#">
                                            <div class="tableHead" id="techSpec">
                                                1- What is a Data Feed?
                                                </div>
                                              <div class="clear"></div>
                                            </a>
                                        </h3>
                                        <div class="clients_expand_bg datafeedpanel" style="height:auto; padding-top:20px;" id="opentwotab">
                                   <div id="section1" class="msssubparagraph" style="text-align: left;"> A data feed is a file that contains all of your product information, such as product titles, URLs, image URLs, price, and other important pieces of information Hoppay uses to list your products on our site.  This page documents what information you need to include in your data feed, how to build it and where to make it available for Hoppay to collect and process it.  Feel free to skip to the appropriate sections of this document if you are already familiar with data feeds.
                                                  <div class="msssubheader">Feed File Formats</div>
                                                  <p>Data feeds have several different formats. The formats supported by Hoppay are:<br>
                                                    <br>
                                                    <b>Delimited Feeds (.xls or .csv)</b><br>
													
																										
													<!-- <img src="<?=$this->webroot?>img/datafeedbanner.jpg" alt="" style="display:block; margin:0 auto;" /> -->
													
                                                    <br>
                                                    These feeds are generally the simplest kind of feeds to make. They are most easily created in a spreadsheet program, such as Microsoft Excel. It will look like a table of information, where each row will contain information about your product. For example, a single product in your feed might look like this:</p>
                                                 <div class="responsive_table">   
                                                  <!--<table border="1" cellpadding="7" cellspacing="0">
                                                    <tbody class="table_td">
                                                      <tr valign="TOP" >
                                                        <td ><p>Product ID</p></td>
                                                        <td ><p>Product Title:</p></td>
                                                        <td width="500"><p>Product Description</p></td>
                                                        <td ><p>Product URL</p></td>
                                                        <td><p>Price</p></td>
                                                        <td><p>Brand</p></td>
                                                        <td><p>Condition</p></td>
                                                        <td ><p>Image URLs</p></td>
                                                        <td><p>ISBN</p></td>
                                                        <td><p>MPN</p></td>
                                                        <td><p>UPC</p></td>
                                                        <td><p>Weight</p></td>
                                                        <td><p>Height</p></td>
                                                        <td><p>Width</p></td>
                                                        <td><p>Category</p></td>
                                                        <td><p>Quantity</p></td>
                                                        <td><p>Shipping</p></td>
                                                        <td><p>Tax</p></td>
                                                      </tr>
                                                      <tr valign="TOP">
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p>1</p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p>Samsung Galaxy S Duos 2 S7582</p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p style="width: 300px;">
                                                          -Android v4.2 (Jelly Bean) OS <br>
                                                          -5 MP Primary Camera <br>
                                                          -0.3 MP Secondary Camera <br>
                                                          -Dual SIM (GSM + GSM) <br>
                                                          -Wi-Fi Enabled <br>
                                                          -4-inch TFT Capactive Touchscreen <br>
                                                          -Expandable Storage Capacity of 64 GB <br>
                                                          -1.2 GHz Dual Core Application Processor</p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p>http://www.sample.com/samsung_galaxy_s_duos_2_S7582</p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p>150.99 USD</p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p>Samsung</p></td>
                                                         <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p>NEW</p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p style="width: 354px;">["http://www.sample.com/images/samsung_galaxy.jpg",<br>"http://www.sample.com/images/samsung_galaxy2.jpg",<br>"http://www.sample.com/images/samsung_galaxy3.jpg",<br>"http://www.sample.com/images/samsung_galaxy4.jpg",<br>"http://www.sample.com/images/samsung_galaxy5.jpg",<br>"http://www.sample.com/images/samsung_galaxy6.jpg",<br>"http://www.sample.com/images/samsung_galaxy7.jpg"]</p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)T!important;"><p>ASDER125AD</p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)T!important;"><p></p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)T!important;"><p></p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p>118</p></td>
                                                         <td style="border-bottom: 1px solid rgb(211, 209, 209)T!important;"><p></p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)T!important;"><p></p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p>ELECTRONICS
                                                            &gt;  Mobiles & Accessories  &gt; Mobiles
                                                           </p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p>50</p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p>Free shipping</p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p>13%</p></td>
                                                      </tr>
                                                    </tbody>
                                                  </table>-->
                                                </div>
                                                  <p><br>
                                                    The first row designating what kind of information is in each column is referred to as a <b>header</b>. Please be sure to include this in your feeds.</p>
                                          </div>
                                        </div>
                                    </div>                                    
                                  <!--  2nd tab end  -->                                     
                                  
                                  <!--  3rd tab start  -->                                    
                                  <div>
                                        <h3>
                                            <a href="#">
                                            <div class="tableHead" id="techSpec">
                                               2- DATA FEED SET UP STEPS:
                                            </div>
                                              <div class="clear"></div>
                                            </a>
                                        </h3>
                                        <div class="clients_expand_bg" style="height:auto;" id="openthreetab">
                                            <div id="section2" class="msssubparagraph" style="text-align:left">
                                                 
                                                  <!--<p> To create a feed, you'll need Microsoft® Excel or a similar spreadsheet program. </p>-->
                                                <div class="msssubheader"><strong>Step 1 - Sign in to your Merchant account</strong></div>
                                                <br> <img src="<?=$this->webroot?>app/webroot/images/front-end/datafeed/step1.PNG" alt="" > <br>
                                                  <br><br>
                                                 
                                                  <div class="msssubheader"><strong>Step 2 - Click on "Data Feed Setup"</strong></div>
                                                  <br> <img src="<?=$this->webroot?>app/webroot/images/front-end/datafeed/step2.PNG" alt="" ><br>
                                                  <br><br>
                                                   <div class="msssubheader"><strong>Step 3 - Click on "Download the Data Feed format"</strong></div>
                                                 <br><img src="<?=$this->webroot?>app/webroot/images/front-end/datafeed/step3.PNG" alt="" ><br>
                                                  <br><br>
												   <div class="msssubheader"><strong>Step 4 - Now save your feed (using Microsoft Excel in our example): 1.	In your spreadsheet program, click File > Save As.</strong></div>
                                                  <br><img src="<?=$this->webroot?>app/webroot/images/front-end/datafeed/step4.PNG" alt="" ><br>
                                                  <br><br>
												   <div class="msssubheader"><strong>Step 5 - On the next screen, click on "Save as type": (Select Excel 97-2003 workbook or select either CSV (Comma delimited) ).</strong></div>
                                                  <br> <img src="<?=$this->webroot?>app/webroot/images/front-end/datafeed/step5.PNG" alt="" ><br>
                                                  <br><br>
												   <div class="msssubheader"><strong>Step 6 - In the "File name" give your File name and click on "Save" button.</strong></div>
                                         
												  <br><img src="<?=$this->webroot?>app/webroot/images/front-end/datafeed/step6.PNG" alt="" ><br> <br>
												  If want to save your file in "CSV" format then a window pops up asking if you want to keep the workbook in this format, click "Yes". <br>
												  <br> <img src="<?=$this->webroot?>app/webroot/images/front-end/datafeed/step7.PNG" alt="" ><br>
												   Now your feed is ready to upload.
												  <br>
                                                  <br><br>
												   <div class="msssubheader"><strong>Step 7 - Now enter your product details. </strong></div> <br>
                                                •	<strong style="color:black;">keep in mind while creating your feed:</strong><br><br>

Please include header row information for each column in your feed. <br>
•	Do not include extra tabs at the ends of lines or within the text in your feed, particularly in your Detailed Descriptions.<br>
•	Do not include extra column.

<br>
                                                  <br><br>
												   <div class="msssubheader"><strong>Step 8 - Now click on "Browse" button.</strong></div>
                                                 <br> <img src="<?=$this->webroot?>app/webroot/images/front-end/datafeed/step8.PNG" alt="" ><br>
                                                  <br><br>
												   <div class="msssubheader"><strong>Step 9 - Select your file and click on "Open" button.</strong></div>
                                                  <br><img src="<?=$this->webroot?>app/webroot/images/front-end/datafeed/step9.PNG" alt="" ><br>
                                                  <br><br>
												   <div class="msssubheader"><strong>Step 10 - Click on "Import" Button. Now Your Data Feed is uploaded into Hoppay Merchant.</strong></div>
                                                   <br><img src="<?=$this->webroot?>app/webroot/images/front-end/datafeed/step10.PNG" alt="" ><br>
                                                 
                                                 <!-- <b>Some things to keep in mind while creating your feed:</b><br>
                                                  <br><br>
                                                  - Please include header row information for each column in your feed. Doing so will help us process it more quickly. <br>
                                                  - Do not include extra tabs at the ends of lines or within the text in your feed, particularly in your Detailed Descriptions. <br>
                                                  <div class="msssubheader">Step 4 - Save your feed</div>
                                                  We require that you save your file as a comma or tab delimited text file. We'll tell you how to do that below. <br>
                                                  <br><br>
                                                  <strong>Before you save:</strong>
                                                  <br />
                                                  
                                                  
                                                      <ul style="list-style:decimal outside none;padding-left:40px;">
                                                        <li>If you are using our sample feed as a template, be sure to delete all empty rows (and the rows with instructions).</li>
                                                        <li>Remove all sample data that remains after entering your inventory.</li>
                                                      </ul>
                                                     <br />
                                                  How to save your feed (using Microsoft Excel in our example): <br>
                                                  
                                                  That's it. Your feed is now ready to upload.
                                                  <div class="msssubheader">Step 5 - Upload your feed to our site</div>
                                                  Now that your feed is ready to go, return to the merchant signup page and follow the instructions to upload your feed to Menacompare.-->
                                                  
                                                  <div class="clear" style="height:10px;"></div>
                                                </div>
                                        </div>
                                    </div>
                                    
                                    <!--  3rd tab end  -->
                                    
                          
                                  <!-- 4th  tab start  -->
                                  
                                  <div>
                                        <h3>
                                            <a href="#" id="four">
                                            <div class="tableHead" id="techSpec">
                                               3- Feed Requirements and Guidelines
                                            </div>
                                              <div class="clear"></div>
                                            </a>
                                        </h3>
                                        <div class="clients_expand_bg" style="height:auto;text-align:left" id="openfourtab">
                                                <div id="section1" class="msssubparagraph">
                                                  <h4>This table is a summary of our feed requirements, depending on the types of products sold.</h4>
                                                  <table border="1"  class="datafeed_desc" cellpadding="6" style="display:block;!important" cellspacing="0">
                                                    <tbody>
                                                      <tr valign="TOP">
                                                        <td><p><br>
                                                          </p></td>
                                                        <td><p><br>
                                                          </p></td>
                                                        <td><p>Conditions</p></td>
                                                        <td><p>Descriptions</p></td>
                                                        <td><p>Examples</p></td>
                                                        
                                                      </tr>
                                                      <tr valign="TOP">
                                                        <td rowspan="12"><p>General Feed Information</p></td>
                                                        <td><p>Product ID</p></td>
                                                        <td><p>Required</p></td>
                                                        <td><p>The identifier for each item has to be unique within your account, and cannot be re-used between feeds. If you have multiple feeds, ids of items within different feeds must still be unique. You can use any sequence of letters and digits for the item id.</p></td>
                                                        <td><p><table>
                                                          <tr> 
                                                            <td>Type  </td><td> numeric </td> 
                                                          </tr>
                                                          <tr> 
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;">Text/Tab delimited  </td><td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"> 1205 </td>
                                                          </tr>
                                                         </table>
                                                        </p></td>
                                                        
                                                      </tr>
                                                      <tr valign="TOP">
                                                        <td><p>Product Title</p></td>
                                                        <td><p>Required</p></td>
                                                        <td><p>This is the name of your item which is required. We recommend you include characteristics such as color or brand in the title which differentiates the item from other products.</p></td>
                                                        <td><p><table>
                                                          <tr> 
                                                            <td>Type  </td><td> Text (Should not be longer than 70 characters) </td> 
                                                          </tr>
                                                          <tr> 
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;">Text/Tab delimited  </td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"> Samsung Galaxy S Duos 2 S7582 </td>
                                                          </tr>
                                                         </table></p></td>
                                                        
                                                      </tr>
                                                      <tr valign="TOP">
                                                        <td><p>Product Title (Arabic)</p></td>
                                                        <td><p>Recommended</p></td>
                                                        <td><p></p></td>
                                                        <td><p><table>
                                                          <tr> 
                                                            <td>Type  </td><td> String </td> 
                                                          </tr>
                                                          <tr> 
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;">Text/Tab delimited  </td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"> Samsung Galaxy S Duos 2 S7582 </td>
                                                          </tr>
                                                         </table></p></td>
                                                        
                                                      </tr>
                                                      <tr valign="TOP">
                                                        <td><p>Product Description</p></td>
                                                        <td><p>Required</p></td>
                                                        <td><p>Include only information relevant to the item. Describe its most relevant attributes, such as size, material, intended age range, special features, or other technical specs. Also include details about the item’s most visual attributes, such as shape, pattern, texture, and design, since we may use this text for finding your item.</p></td>
                                                        <td><p><table>
                                                          <tr> 
                                                            <td>Type  </td><td> Text </td> 
                                                          </tr>
                                                          <tr> 
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;">Text/Tab delimited  </td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"> Android v4.2 (Jelly Bean) OS,
                                                          5 MP Primary Camera,
                                                          0.3 MP Secondary Camera, 
                                                          Dual SIM (GSM + GSM), 
                                                          Wi-Fi Enabled,
                                                          4-inch TFT Capactive Touchscreen ,
                                                          Expandable Storage Capacity of 64 GB ,
                                                          1.2 GHz Dual Core Application Processor ,
                                                          </tr>
                                                         </table></p></td>
                                                      </tr>
                                                      <tr valign="TOP">
                                                        <td><p>Product Description (Arabic)</p></td>
                                                        <td><p>Recommended</p></td>
                                                        <td><p>Description</p></td>
                                                        <td><p><table>
                                                          <tr> 
                                                            <td>Type  </td><td> String </td> 
                                                          </tr>
                                                          <tr> 
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;">Text/Tab delimited  </td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"> Samsung Galaxy S Duos 2 S7582 </td>
                                                          </tr>
                                                         </table></p></td>
                                                      </tr>
                                                      <tr valign="TOP">
                                                        <td><p>Category</p></td>
                                                        <td><p>Required</p></td>
                                                        <td><p>The 'Hoppay product category' attribute indicates the category of the product being submitted, according to the Hoppay product taxonomy. This attribute accepts only one value, taken from the product taxonomy tree. </p></td>
                                                        <td><p><table>
                                                          <tr> 
                                                            <td>Type  </td><td> String </td> 
                                                          </tr>
                                                          <tr> 
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;">Text/Tab delimited  </td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"> Electronics > Mobiles & Accessories > Mobiles </td>
                                                          </tr>
                                                         </table></p></td>
                                                        
                                                      </tr>
                                                      <tr valign="TOP">
                                                        <td><p>Product URL</p></td>
                                                        <td><p>Required</p></td>
                                                        <td><p>The user is sent to this URL when your item is clicked on Hoppay Shopping.The URL contained in this attribute is a direct link to your product page.</p></td>
                                                        <td><p><table>
                                                          <tr> 
                                                            <td>Type  </td><td> URL (this must include the http:// portion)</td> 
                                                          </tr>
                                                          <tr> 
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;">Text/Tab delimited  </td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"> http://www.sample.com/samsung_galaxy_s_duos_2_S7582 </td>
                                                          </tr>
                                                         </table></p></td>
                                                        
                                                      </tr>
                                                      <tr valign="TOP">
                                                        <td><p>Price</p></td>
                                                        <td><p>Required</p></td>
                                                        <td><p>The price of the item has to be the most prominent price on the landing page. If multiple items are on the same page with multiple prices, it has to be straightforward for the user to find the correct item and corresponding price.</p></td>
                                                        <td><p><table>
                                                          <tr> 
                                                            <td>Type  </td><td> Number </td> 
                                                          </tr>
                                                          <tr> 
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;">Text/Tab delimited  </td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"> 15.00 USD </td>
                                                          </tr>
                                                         </table></p></td>
                                                       
                                                      </tr>
                                                      <tr valign="TOP">
                                                        <td><p>Brand</p></td>
                                                        <td><p>Recommended</p></td>
                                                        <td><p> Required according to the Unique Product Identifier Rules for all target countries</p></td>
                                                        <td><p><table>
                                                          <tr> 
                                                            <td>Type  </td><td> Text </td> 
                                                          </tr>
                                                          <tr> 
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;">Text/Tab delimited  </td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"> Samsung </td>
                                                          </tr>
                                                         </table></p></td>
                                                       
                                                      </tr>
                                                      <tr valign="TOP">
                                                        <td><p>Image URLs</p></td>
                                                        <td><p>Required</p></td>
                                                        <td><p>This is the URL of an associated image for a product.
If you have multiple different images of the item, also you can put it here.</p></td>
                                                        <td><p><table>
                                                          <tr> 
                                                            <td>Type  </td><td> URL. (Must start with 'http://' or 'https://'.) </td> 
                                                          </tr>
                                                          <tr> 
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;">Text/Tab delimited  </td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"> ["http://www.sample.com/images/samsung_galaxy.jpg" ,
                                                            "http://www.sample.com/images/samsung_galaxy2.jpg" ,
                                                            "http://www.sample.com/images/samsung_galaxy3.jpg" ] </td>
                                                          </tr>
                                                         </table></p></td>
                                                        
                                                      </tr>
                                                      <tr valign="TOP">
                                                        <td><p>Condition</p></td>
                                                        <td><p>Required</p></td>
                                                        <td><p>There are only three accepted values: <br>

'new': The product is brand-new and has never been used. It's in its original packaging which has not been opened. <br>
'refurbished': The product has been restored to working order. This includes, for example, remanufactured printer cartridges. <br>
'used': If the two previous values don't apply. For example, if the product has been used before or the original packaging has been opened or is missing.</p></td>
                                                        <td><p><table>
                                                          <tr> 
                                                            <td>Type  </td><td> Three predefined values accepted:<br>('new'/'used'/'refurbished') </td> 
                                                          </tr>
                                                          <tr> 
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;">Text/Tab delimited  </td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"> new </td>
                                                          </tr>
                                                         </table></p></td>
                                                      </tr>                                                      
                                                      <tr valign="TOP">
                                                        <td><p>Quantity</p></td>
                                                        <td><p>Required</p></td>
                                                        <td><p>How many no. of same product you have. </p></td>
                                                        <td><p><table>
                                                          <tr> 
                                                            <td>Type  </td><td> Number </td> 
                                                          </tr>
                                                          <tr> 
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;">Text/Tab delimited  </td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"> 274 </td>
                                                          </tr>
                                                         </table></p></td>
                                                      </tr>
                                                     
                                                      <tr valign="TOP">
                                                        <td rowspan="3"><p>Additional Product Information</p></td>
                                                        <td><p>ISBN</p></td>
                                                        <td><p>Recommended</p></td>
                                                        <td><p>New books (published after 1970): provide ISBN  attribute. It only use for books</p></td>
                                                        <td><p></p></td>
                                                       
                                                      </tr>
                                                      <tr valign="TOP">
                                                       
                                                        <td><p>MPN (Manufacturer Part Number)</p></td>
                                                        <td ><p>Recommended</p></td>
                                                        <td ><p>Manufacturer-issued part number for the product. The MPN is case-insensitive. Duplicate MPNs should not be submitted, as only the first product will be recognized. All other duplicates will be dropped. </p></td>
                                                        <td><p></p></td>
                                                       
                                                      </tr>
                                                      <tr valign="TOP">
                                                         
                                                        <td><p>UPC</p></td>
                                                        <td ><p>Recommended</p></td>
                                                        <td ><p>Description</p></td>
                                                        <td><p></p></td>
                                                      </tr>
                                                      
                                                      <tr valign="TOP">
                                                        <td rowspan="2"><p>Attribute Information</p></td>
                                                        <td><p>Height</p></td>
                                                        <td><p>Recommended</p></td>
                                                        <td><p>If needed you provide this information.</p></td>
                                                        <td><p><table>
                                                          <tr> 
                                                            <td>Type  </td><td> number (cm) </td> 
                                                          </tr>
                                                          <tr> 
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;">Text/Tab delimited  </td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"> 20  </td>
                                                          </tr>
                                                         </table></p></td>
                                                      
                                                      </tr>
                                                      <tr valign="TOP">
                                                        <td><p>Width</p></td>
                                                        <td><p>Recommended</p></td>
                                                        <td><p>If needed you provide this information.</p></td>
                                                        <td><p><table>
                                                          <tr> 
                                                            <td>Type  </td><td> number (cm) </td> 
                                                          </tr>
                                                          <tr> 
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;">Text/Tab delimited  </td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"> 50  </td>
                                                          </tr>
                                                         </table></p></td>
                                                        
                                                      </tr>                                              
                                                      
                                                     
                                                      <tr valign="TOP">
                                                        <td rowspan="2" style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p>Shipping Information</p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p>Shipping</p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;" ><p style="text-align:left;">Recommended</p></td>
                                                        <td><p>This attribute provides the specific shipping estimate for the product. Providing this attribute for an item overrides the global shipping settings you defined in your Hoppay Merchant Center settings.</p></td>
                                                        <td><p><table>
                                                          <tr> 
                                                            <td>Type  </td><td> String </td> 
                                                          </tr>
                                                          <tr> 
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;">Text/Tab delimited  </td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"> Free shipping </td>
                                                          </tr>
                                                         </table></p></td>
                                                      </tr>
                                                      <tr  style="border-bottom: 1px solid rgb(211, 209, 209)!important;" valign="TOP">
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p>Weight</p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;" ><p style="text-align:left;">Recommended</p></td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p>This is the weight of the product used to calculate the shipping cost of the item. If you have specified a global shipping rule that is dependent on shipping weight, this attribute will be used to calculate the shipping cost of the item automatically.</p></td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p><table>
                                                          <tr> 
                                                            <td>Type  </td><td> Number (Kg) </td> 
                                                          </tr>
                                                          <tr> 
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;">Text/Tab delimited  </td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"> 20 </td>
                                                          </tr>
                                                         </table></p></td>
                                                      </tr>
                                                       <tr valign="TOP">
                                                        <td rowspan="1" style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p>Tax Information</p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p>Tax</p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;" ><p style="text-align:left;">Recommended </p></td>
                                                        <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p></p></td>
                                                            <td style="border-bottom: 1px solid rgb(211, 209, 209)!important;"><p></p></td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                 
                                               
                                                  
                                        </div>
                                    </div>
                                    
                                  <!-- 4th  tab end  --> 
                              </div>
                <div class="clear" style="height:50px;">&nbsp;</div>
                </div>
            </div>
        </div>
        
        </div>