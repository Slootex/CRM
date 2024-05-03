<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "style";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$html = "Es wurde keine eine ID angegeben!";

if(isset($param['id']) && isset($param['id'])){

	$row_design = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `design` WHERE `design`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `design`.`id`='" . mysqli_real_escape_string($conn, intval($param['id'])) . "'"), MYSQLI_ASSOC);

	if(isset($row_design['id']) && intval($row_design['id']) > 0){

		$html = "        <!-- Jumbotron -->
        <div class=\"jumbotron\">
            <h1>Styleangaben Vorschau</h1>
            <p>" . $row_design['description'] . "</p>
            <p>
                <a class=\"btn btn-lg btn-primary\" href=\"//ordergo.de/\" role=\"button\">OrgerGo »</a>
            </p>
        </div>

        <!-- Typography -->
        <div class=\"row tall-row\">
            <div class=\"col-lg-12\">
                <h1>Typography</h1>
                <hr>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-md-4\">
                <h1>Heading 1</h1>
                <h2>Heading 2</h2>
                <h3>Heading 3</h3>
                <h4>Heading 4</h4>
                <h5>Heading 5</h5>
                <h6>Heading 6</h6>
            </div>
            <div class=\"col-md-4\">
                <h2>Example body text</h2>
                <p>Doge doge doge doge <a href=\"#\">Yeah!</a> Doge doge doge doge doge doge doge doge doge.</p>
                <p><small>Fine print</small></p>
                <p><strong>Bold text</strong>.</p>
                <p><em>Italicized text</em>.</p>
            </div>
            <div class=\"col-md-4\">
                <h2>Emphasis classes</h2>
                <p class=\"text-primary\">You put the emPHAsis on the wrong syLLAbles.</p>
                <p class=\"text-warning\">Has Anyone Really Been Far Even as Decided to Use Even Go Want to do Look More Like?</p>
                <p class=\"text-danger\">If the answer to all questions is yes, so why not?</p>
                <p class=\"text-success\">And when everyone is super, no one will be.</p>
                <p class=\"text-info\">The force will be with you, always.</p>
            </div>
        </div>

        <!-- Buttons -->
        <div class=\"row tall-row\">
            <div class=\"col-lg-12\">
                <h1>Buttons</h1>
                <hr>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-sm-6\">
                <a href=\"#\" class=\"btn btn-default\">Default</a>
                <a href=\"#\" class=\"btn btn-primary\">Primary</a>
                <a href=\"#\" class=\"btn btn-success\">Success</a>
                <a href=\"#\" class=\"btn btn-info\">Info</a>
                <a href=\"#\" class=\"btn btn-warning\">Warning</a>
                <a href=\"#\" class=\"btn btn-danger\">Danger</a>
            </div>
            <div class=\"col-sm-6\">
            </div>
        </div>

        <!-- Tables -->
        <div class=\"row tall-row\">
            <div class=\"col-lg-12\">
                <h1>Tables</h1>
                <hr>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-lg-12\">\n" . 
				"	<table class=\"table table-" . $row_design["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"		<thead><tr class=\"bg-" . $row_design["bgcolor_table_head"] . " text-" . $row_design["color_table_head"] . "\">\n" . 
				"			<th width=\"40\" scope=\"col\">\n" . 
				"				<div class=\"custom-control custom-checkbox mt-0 ml-2\">\n" . 
				"					<input type=\"checkbox\" id=\"order_sel_all_top\" class=\"custom-control-input\" onclick=\"var check = \$('#order_sel_all_bottom').prop('checked');\$('#order_sel_all_bottom').prop('checked', this.checked);\$('.order-list').each(function(){\$(this).prop('checked', !check);if(check == true){\$(this).closest('tr').removeClass('active');}else{\$(this).closest('tr').addClass('active');}});\" />\n" . 
				"					<label class=\"custom-control-label\" for=\"order_sel_all_top\"></label>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>House</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Sigil</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Seat</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"		</tr></thead>\n" . 

                    "<tbody>
                        <tr>
                            <td>1</td>
                            <td>Stark</td>
                            <td>Direwolf</td>
                            <td>Winterfell</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Lannister</td>
                            <td>Lion</td>
                            <td>Casterly Rock</td>
                        </tr>
                        <tr class=\"info\">
                            <td>3</td>
                            <td>Baratheon</td>
                            <td>Stag</td>
                            <td>Storm's End</td>
                        </tr>
                        <tr class=\"success\">
                            <td>4</td>
                            <td>Targaryen</td>
                            <td>3-headed Dragon</td>
                            <td>Slaver's Bay</td>
                        </tr>
                        <tr class=\"danger\">
                            <td>5</td>
                            <td>Martell</td>
                            <td>Sun pierced by a spear</td>
                            <td>Sunspear</td>
                        </tr>
                        <tr class=\"warning\">
                            <td>6</td>
                            <td>Tully</td>
                            <td>Trout</td>
                            <td>Riverrun</td>
                        </tr>
                        <tr class=\"active\">
                            <td>7</td>
                            <td>Bolton</td>
                            <td>Red flayed man</td>
                            <td>Dreadfort / Winterfell</td>
                        </tr>
                    </tbody>
                </table> 
            </div>
        </div>

        <!-- Progress Bars -->
        <div class=\"row tall-row\">
            <div class=\"col-lg-12\">
                <h1>Progress Bars</h1>
                <hr>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <h3>Normal</h3>
                <div class=\"progress\">
                    <div class=\"progress-bar\" style=\"width: 15%\"></div>
                </div>
                <div class=\"progress\">
                    <div class=\"progress-bar progress-bar-info\" style=\"width: 30%\"></div>
                </div>
                <div class=\"progress\">
                    <div class=\"progress-bar progress-bar-success\" style=\"width: 45%\"></div>
                </div>
                <div class=\"progress\">
                    <div class=\"progress-bar progress-bar-warning\" style=\"width: 60%\"></div>
                </div>
                <div class=\"progress\">
                    <div class=\"progress-bar progress-bar-danger\" style=\"width: 75%\"></div>
                </div>
            </div>
            <div class=\"col-lg-12\">
                <h3>Striped</h3>
                <div class=\"progress progress-striped\">
                    <div class=\"progress-bar\" style=\"width: 15%\"></div>
                </div>
                <div class=\"progress progress-striped\">
                    <div class=\"progress-bar progress-bar-info\" style=\"width: 30%\"></div>
                </div>
                <div class=\"progress progress-striped\">
                    <div class=\"progress-bar progress-bar-success\" style=\"width: 45%\"></div>
                </div>
                <div class=\"progress progress-striped\">
                    <div class=\"progress-bar progress-bar-warning\" style=\"width: 60%\"></div>
                </div>
                <div class=\"progress progress-striped\">
                    <div class=\"progress-bar progress-bar-danger\" style=\"width: 75%\"></div>
                </div>
            </div>
            <div class=\"col-lg-12\">
                <h3>Animated</h3>
                <div class=\"progress progress-striped active\">
                    <div class=\"progress-bar  progress-bar-info\" style=\"width: 45%\"></div>
                </div>
            </div>
            <div class=\"col-lg-12\">
                <h3>Stacked</h3>
                <div class=\"progress\">
                    <div class=\"progress-bar progress-bar-success\" style=\"width: 35%\"></div>
                    <div class=\"progress-bar progress-bar-warning\" style=\"width: 20%\"></div>
                    <div class=\"progress-bar progress-bar-danger\" style=\"width: 10%\"></div>
                </div>
            </div>
        </div>

        <!-- Forms -->
        <div class=\"row tall-row\">
            <div class=\"col-lg-12\">
                <h1>Forms</h1>
                <hr>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-lg-6\">
                <div class=\"well\">
                    <form class=\"form-horizontal\">
                        <fieldset>
                            <legend>Legend</legend>
                            <div class=\"form-group\">
                                <label for=\"inputEmail\" class=\"col-lg-2 control-label\">Email</label>
                                <div class=\"col-lg-10\">
                                    <input class=\"form-control\" id=\"inputEmail\" placeholder=\"Email\" type=\"text\">
                                </div>
                            </div>
                            <div class=\"form-group\">
                                <label for=\"inputPassword\" class=\"col-lg-2 control-label\">Password</label>
                                <div class=\"col-lg-10\">
                                    <input class=\"form-control\" id=\"inputPassword\" placeholder=\"Password\" type=\"password\">
                                    <div class=\"checkbox\">
                                        <label>
                                            <input type=\"checkbox\"> Checkbox
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class=\"form-group\">
                                <label for=\"textArea\" class=\"col-lg-2 control-label\">Textarea</label>
                                <div class=\"col-lg-10\">
                                    <textarea class=\"form-control\" rows=\"3\" id=\"textArea\"></textarea>
                                    <span class=\"help-block\">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
                                </div>
                            </div>
                            <div class=\"form-group\">
                                <label class=\"col-lg-2 control-label\">Radios</label>
                                <div class=\"col-lg-10\">
                                    <div class=\"radio\">
                                        <label>
                                            <input name=\"optionsRadios\" id=\"optionsRadios1\" value=\"option1\" checked=\"\" type=\"radio\">
                                            Option one is this
                                        </label>
                                    </div>
                                    <div class=\"radio\">
                                        <label>
                                            <input name=\"optionsRadios\" id=\"optionsRadios2\" value=\"option2\" type=\"radio\">
                                            Option two can be something else
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class=\"form-group\">
                                <label for=\"select\" class=\"col-lg-2 control-label\">Selects</label>
                                <div class=\"col-lg-10\">
                                    <select class=\"form-control\" id=\"select\">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                    <br>
                                    <select multiple=\"\" class=\"form-control\">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>
                            <div class=\"form-group\">
                                <div class=\"col-lg-10 col-lg-offset-2\">
                                    <button type=\"reset\" class=\"btn btn-default\">Cancel</button>
                                    <button type=\"submit\" class=\"btn btn-primary\">Submit</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class=\"col-lg-4 col-lg-offset-1\">
                <form class=\"bs-component\">
                    <div class=\"form-group\">
                        <label class=\"control-label\" for=\"focusedInput\">Focused input</label>
                        <input class=\"form-control\" id=\"focusedInput\" value=\"This is focused...\" type=\"text\">
                    </div>
                    <div class=\"form-group\">
                        <label class=\"control-label\" for=\"disabledInput\">Disabled input</label>
                        <input class=\"form-control\" id=\"disabledInput\" placeholder=\"Disabled input here...\" disabled=\"\" type=\"text\">
                    </div>
                    <div class=\"form-group has-warning\">
                        <label class=\"control-label\" for=\"inputWarning\">Input warning</label>
                        <input class=\"form-control\" id=\"inputWarning\" type=\"text\">
                    </div>
                    <div class=\"form-group has-error\">
                        <label class=\"control-label\" for=\"inputError\">Input error</label>
                        <input class=\"form-control\" id=\"inputError\" type=\"text\">
                    </div>
                    <div class=\"form-group has-success\">
                        <label class=\"control-label\" for=\"inputSuccess\">Input success</label>
                        <input class=\"form-control\" id=\"inputSuccess\" type=\"text\">
                    </div>
                    <div class=\"form-group\">
                        <label class=\"control-label\" for=\"inputLarge\">Large input</label>
                        <input class=\"form-control input-lg\" id=\"inputLarge\" type=\"text\">
                    </div>
                    <div class=\"form-group\">
                        <label class=\"control-label\" for=\"inputDefault\">Default input</label>
                        <input class=\"form-control\" id=\"inputDefault\" type=\"text\">
                    </div>
                    <div class=\"form-group\">
                        <label class=\"control-label\" for=\"inputSmall\">Small input</label>
                        <input class=\"form-control input-sm\" id=\"inputSmall\" type=\"text\">
                    </div>
                    <div class=\"form-group\">
                        <label class=\"control-label\">Input addons</label>
                        <div class=\"input-group\">
                            <span class=\"input-group-addon\">$</span>
                            <input class=\"form-control\" type=\"text\">
                            <span class=\"input-group-btn\">
                                <button class=\"btn btn-default\" type=\"button\">Button</button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Navs -->
        <div class=\"row tall-row\">
            <div class=\"col-lg-12\">
                <h1>Navs</h1>
                <hr>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-md-4\">
                <h3>Pagination</h3>
                <ul class=\"pagination pagination-lg\">
                    <li class=\"disabled\"><a href=\"#\">«</a></li>
                    <li class=\"active\"><a href=\"#\">1</a></li>
                    <li><a href=\"#\">2</a></li>
                    <li><a href=\"#\">3</a></li>
                    <li><a href=\"#\">4</a></li>
                    <li><a href=\"#\">»</a></li>
                </ul>
                <ul class=\"pagination\">
                    <li class=\"disabled\"><a href=\"#\">«</a></li>
                    <li class=\"active\"><a href=\"#\">1</a></li>
                    <li><a href=\"#\">2</a></li>
                    <li><a href=\"#\">3</a></li>
                    <li><a href=\"#\">4</a></li>
                    <li><a href=\"#\">»</a></li>
                </ul>
                <ul class=\"pagination pagination-sm\">
                    <li class=\"disabled\"><a href=\"#\">«</a></li>
                    <li class=\"active\"><a href=\"#\">1</a></li>
                    <li><a href=\"#\">2</a></li>
                    <li><a href=\"#\">3</a></li>
                    <li><a href=\"#\">4</a></li>
                    <li><a href=\"#\">»</a></li>
                </ul>
            </div>
            <div class=\"col-md-4\">
                <h3>Breadcrumbs</h3>
                <div class=\"bs-component\">
                    <ul class=\"breadcrumb\">
                        <li class=\"active\">Home</li>
                    </ul>
                    <ul class=\"breadcrumb\">
                        <li><a href=\"#\">Home</a></li>
                        <li class=\"active\">Library</li>
                    </ul>
                    <ul class=\"breadcrumb\">
                        <li><a href=\"#\">Home</a></li>
                        <li><a href=\"#\">Library</a></li>
                        <li class=\"active\">Data</li>
                    </ul>
                </div>
            </div>
            <div class=\"col-md-4\">
                <h3>Tabs</h3>
                <ul class=\"nav nav-tabs\">
                    <li class=\"active\"><a aria-expanded=\"true\" href=\"#home\" data-toggle=\"tab\">Home</a></li>
                    <li class=\"\"><a aria-expanded=\"false\" href=\"#profile\" data-toggle=\"tab\">Profile</a></li>
                    <li class=\"dropdown\">
                        <a aria-expanded=\"false\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">Dropdown <span class=\"caret\"></span>
                        </a>
                        <ul class=\"dropdown-menu\">
                            <li><a href=\"#dropdown1\" data-toggle=\"tab\">Bacon</a></li>
                            <li class=\"divider\"></li>
                            <li><a href=\"#dropdown2\" data-toggle=\"tab\">Zen of Python</a></li>
                        </ul>
                    </li>
                </ul>
                <div id=\"myTabContent\" class=\"tab-content\">
                    <div class=\"tab-pane fade active in\" id=\"home\">
                        <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
                    </div>
                    <div class=\"tab-pane fade\" id=\"profile\">
                        <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit.</p>
                    </div>
                    <div class=\"tab-pane fade\" id=\"dropdown1\">
                        <p>Bacon ipsum dolor amet kielbasa bacon swine boudin brisket hamburger bresaola chicken filet mignon fatback leberkas beef ribs salami. Leberkas rump ball tip landjaeger bresaola salami drumstick sausage pork loin picanha pork chop. Sausage short loin swine pork filet mignon pork belly landjaeger cupim, frankfurter corned beef venison drumstick. Filet mignon rump picanha drumstick shank ball tip doner frankfurter shoulder. Meatloaf tri-tip porchetta tail, fatback boudin rump strip steak doner cow jerky pork loin turkey cupim. Cupim prosciutto sausage kevin pork loin, beef ribs chuck tail salami rump meatloaf shank. Pork belly fatback chuck, alcatra short ribs kevin landjaeger drumstick pig tongue jowl.</p>
                    </div>
                    <div class=\"tab-pane fade\" id=\"dropdown2\">
                        <p>Beautiful is better than ugly. Explicit is better than implicit. Simple is better than complex. Complex is better than complicated. Flat is better than nested. Sparse is better than dense. Readability counts. Special cases aren't special enough to break the rules. Although practicality beats purity. Errors should never pass silently. Unless explicitly silenced. In the face of ambiguity, refuse the temptation to guess. There should be one-- and preferably only one --obvious way to do it. Although that way may not be obvious at first unless you're Dutch. Now is better than never. Although never is often better than *right* now. If the implementation is hard to explain, it's a bad idea. If the implementation is easy to explain, it may be a good idea. Namespaces are one honking great idea -- let's do more of those!</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panels -->
        <div class=\"row tall-row\">
            <div class=\"col-lg-12\">
                <h1>Panels</h1>
                <hr>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-md-4\">
                <div class=\"panel panel-default\">
                    <div class=\"panel-body\">Basic panel</div>
                </div>

                <div class=\"panel panel-default\">
                    <div class=\"panel-heading\">Panel heading</div>
                    <div class=\"panel-body\">Panel content</div>
                </div>

                <div class=\"panel panel-default\">
                    <div class=\"panel-body\">Panel content</div>
                    <div class=\"panel-footer\">Panel footer</div>
                </div>
            </div>
            <div class=\"col-md-4\">
                <div class=\"panel panel-primary\">
                    <div class=\"panel-heading\"><h3 class=\"panel-title\">Panel primary</h3></div>
                    <div class=\"panel-body\">Panel content</div>
                </div>

                <div class=\"panel panel-success\">
                    <div class=\"panel-heading\"><h3 class=\"panel-title\">Panel success</h3></div>
                    <div class=\"panel-body\">Panel content</div>
                </div>

                <div class=\"panel panel-warning\">
                    <div class=\"panel-heading\"><h3 class=\"panel-title\">Panel warning</h3></div>
                    <div class=\"panel-body\">Panel content</div>
                </div>
            </div>
            <div class=\"col-md-4\">
                <div class=\"panel panel-danger\">
                    <div class=\"panel-heading\"><h3 class=\"panel-title\">Panel danger</h3></div>
                    <div class=\"panel-body\">Panel content</div>
                </div>
                <div class=\"panel panel-info\">
                    <div class=\"panel-heading\"><h3 class=\"panel-title\">Panel info</h3></div>
                    <div class=\"panel-body\">Panel content</div>
                </div>
            </div>
        </div>

        <!-- List Groups -->
        <div class=\"row tall-row\">
            <div class=\"col-lg-12\">
                <h1>List Groups</h1>
                <hr>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-lg-4\">
                <ul class=\"list-group\">
                    <li class=\"list-group-item\">
                        <span class=\"badge\">14</span>
                        Cras justo odio
                    </li>
                    <li class=\"list-group-item\">
                        <span class=\"badge\">2</span>
                        Dapibus ac facilisis in
                    </li>
                    <li class=\"list-group-item\">
                        <span class=\"badge\">1</span>
                        Morbi leo risus
                    </li>
                </ul>
            </div>
            <div class=\"col-lg-4\">
                <div class=\"list-group\">
                    <a href=\"#\" class=\"list-group-item active\">Cras justo odio</a>
                    <a href=\"#\" class=\"list-group-item\">Dapibus ac facilisis in</a>
                    <a href=\"#\" class=\"list-group-item\">Morbi leo risus</a>
                </div>
            </div>
            <div class=\"col-lg-4\">
                <div class=\"list-group\">
                    <a href=\"#\" class=\"list-group-item\">
                        <h4 class=\"list-group-item-heading\">List group item heading</h4>
                        <p class=\"list-group-item-text\">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                    </a>
                    <a href=\"#\" class=\"list-group-item\">
                        <h4 class=\"list-group-item-heading\">List group item heading</h4>
                        <p class=\"list-group-item-text\">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Wells -->
        <div class=\"row tall-row\">
            <div class=\"col-lg-12\">
                <h1>Wells</h1>
                <hr>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-md-4\">
                <div class=\"well\">
                    Look, I'm in a well!
                </div>
            </div>
            <div class=\"col-md-4\">
                <div class=\"well well-sm\">
                    Look, I'm in a small well!
                </div>
            </div>
            <div class=\"col-md-4\">
                <div class=\"well well-lg\">
                    Look, I'm in a large well!
                </div>
            </div>
        </div>

        <!-- Alerts -->
        <div class=\"row tall-row\">
            <div class=\"col-lg-12\">
                <h2>Alerts</h2>
                <hr>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <div class=\"alert alert-dismissible alert-warning\">
                    <button type=\"button\" class=\"close\">×</button>
                    <h4>Warning!</h4>
                    <p>Best check yo self, you're not looking too good. Nulla vitae elit libero, a pharetra augue. Praesent commodo cursus magna, <a href=\"#\" class=\"alert-link\">vel scelerisque nisl consectetur et</a>.</p>
                </div>
                <div class=\"row\">
                    <div class=\"col-lg-4\">
                        <div class=\"alert alert-dismissible alert-danger\">
                            <button type=\"button\" class=\"close\">×</button>
                            <strong>Oh snap!</strong> <a href=\"#\" class=\"alert-link\">Change a few things up</a> and try submitting again.
                        </div>
                    </div>
                    <div class=\"col-lg-4\">
                        <div class=\"alert alert-dismissible alert-success\">
                            <button type=\"button\" class=\"close\">×</button>
                            <strong>Well done!</strong> You successfully read <a href=\"#\" class=\"alert-link\">this important alert message</a>.
                        </div>
                    </div>
                    <div class=\"col-lg-4\">
                        <div class=\"alert alert-dismissible alert-info\">
                            <button type=\"button\" class=\"close\">×</button>
                            <strong>Heads up!</strong> This <a href=\"#\" class=\"alert-link\">alert needs your attention</a>, but it's not super important.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dialogs -->
        <div class=\"row tall-row\">
            <div class=\"col-lg-12\">
                <h1>Modals</h1>
                <hr>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-md-12\">
                <div class=\"modal\">
                    <div class=\"modal-dialog\">
                        <div class=\"modal-content\">
                            <div class=\"modal-header\">
                                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>
                                <h4 class=\"modal-title\">Potentially Catastrophic Operation</h4>
                            </div>
                            <div class=\"modal-body\">
                                <p>Are you sure you want to do the thing with the stuff? You could rupture the space-time continuum if you fail.</p>
                            </div>
                            <div class=\"modal-footer\">
                                <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
                                <button type=\"button\" class=\"btn btn-primary\">Save changes  </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>";

	}

}

?>