<div id="work_info_modal" class="modal" style="display: block;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Информация о работе</h3>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#main-information" aria-controls="main-information"
                                                              role="tab" data-toggle="tab">Основная информация</a></li>
                    <li role="presentation"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">Комментарии</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="about_work">

                    </div>
                    <div role="tabpanel" class="tab-pane" id="comments">
                        <form class="form form-horizontal" id="commentForm" onsubmit="commentAdd(); return false;">
                            <div class="form-group">
                                <label class="col-sm-4">Заголовок</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="title"
                                           placeholder="Укажите заголовок комментария" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Текст комментария</label>
                                <div class="col-sm-8">
                                    <div id="summernote" style="display: none;"></div>
                                    <div class="note-editor note-frame panel panel-default">
                                        <div class="note-dropzone">
                                            <div class="note-dropzone-message"></div>
                                        </div>
                                        <div class="note-toolbar panel-heading">
                                            <div class="note-btn-group btn-group note-style">
                                                <button type="button"
                                                        class="note-btn btn btn-default btn-sm note-btn-bold"
                                                        tabindex="-1" title="" data-original-title="Bold (CTRL+B)"><i
                                                        class="note-icon-bold"></i></button>
                                                <button type="button"
                                                        class="note-btn btn btn-default btn-sm note-btn-italic"
                                                        tabindex="-1" title="" data-original-title="Italic (CTRL+I)"><i
                                                        class="note-icon-italic"></i></button>
                                                <button type="button"
                                                        class="note-btn btn btn-default btn-sm note-btn-underline"
                                                        tabindex="-1" title="" data-original-title="Underline (CTRL+U)">
                                                    <i class="note-icon-underline"></i></button>
                                                <button type="button" class="note-btn btn btn-default btn-sm"
                                                        tabindex="-1" title=""
                                                        data-original-title="Remove Font Style (CTRL+\)"><i
                                                        class="note-icon-eraser"></i></button>
                                            </div>
                                            <div class="note-btn-group btn-group note-font">
                                                <button type="button"
                                                        class="note-btn btn btn-default btn-sm note-btn-strikethrough"
                                                        tabindex="-1" title=""
                                                        data-original-title="Strikethrough (CTRL+SHIFT+S)"><i
                                                        class="note-icon-strikethrough"></i></button>
                                            </div>
                                            <div class="note-btn-group btn-group note-fontsize"></div>
                                            <div class="note-btn-group btn-group note-color"></div>
                                            <div class="note-btn-group btn-group note-para">
                                                <button type="button" class="note-btn btn btn-default btn-sm"
                                                        tabindex="-1" title=""
                                                        data-original-title="Unordered list (CTRL+SHIFT+NUM7)"><i
                                                        class="note-icon-unorderedlist"></i></button>
                                                <button type="button" class="note-btn btn btn-default btn-sm"
                                                        tabindex="-1" title=""
                                                        data-original-title="Ordered list (CTRL+SHIFT+NUM8)"><i
                                                        class="note-icon-orderedlist"></i></button>
                                            </div>
                                            <div class="note-btn-group btn-group note-height"></div>
                                        </div>
                                        <div class="note-editing-area">
                                            <div class="note-handle">
                                                <div class="note-control-selection">
                                                    <div class="note-control-selection-bg"></div>
                                                    <div class="note-control-holder note-control-nw"></div>
                                                    <div class="note-control-holder note-control-ne"></div>
                                                    <div class="note-control-holder note-control-sw"></div>
                                                    <div class="note-control-sizing note-control-se"></div>
                                                    <div class="note-control-selection-info"></div>
                                                </div>
                                            </div>
                                            <textarea class="note-codable"></textarea>
                                            <div class="note-editable panel-body" contenteditable="true"><p><br></p>
                                            </div>
                                        </div>
                                        <div class="note-statusbar">
                                            <div class="note-resizebar">
                                                <div class="note-icon-bar"></div>
                                                <div class="note-icon-bar"></div>
                                                <div class="note-icon-bar"></div>
                                            </div>
                                        </div>
                                        <div class="modal link-dialog" aria-hidden="false" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span aria-hidden="true">×</span>
                                                        </button>
                                                        <h4 class="modal-title">Insert Link</h4></div>
                                                    <div class="modal-body">
                                                        <div class="form-group note-form-group"><label
                                                                class="note-form-label">Text to display</label><input
                                                                class="note-link-text form-control  note-form-control  note-input"
                                                                type="text"></div>
                                                        <div class="form-group note-form-group"><label
                                                                class="note-form-label">To what URL should this link
                                                                go?</label><input
                                                                class="note-link-url form-control note-form-control note-input"
                                                                type="text" value="http://"></div>
                                                        <div class="checkbox"><label
                                                                for="sn-checkbox-open-in-new-window"> <input
                                                                    type="checkbox" id="sn-checkbox-open-in-new-window"
                                                                    checked="">Open in new window</label></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button href="#"
                                                                class="btn btn-primary note-btn note-btn-primary note-link-btn disabled"
                                                                disabled="">Insert Link
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal" aria-hidden="false" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span aria-hidden="true">×</span>
                                                        </button>
                                                        <h4 class="modal-title">Insert Image</h4></div>
                                                    <div class="modal-body">
                                                        <div
                                                            class="form-group note-form-group note-group-select-from-files">
                                                            <label class="note-form-label">Select from
                                                                files</label><input
                                                                class="note-image-input form-control note-form-control note-input"
                                                                type="file" name="files" accept="image/*"
                                                                multiple="multiple"></div>
                                                        <div class="form-group note-group-image-url"
                                                             style="overflow:auto;"><label class="note-form-label">Image
                                                                URL</label><input
                                                                class="note-image-url form-control note-form-control note-input  col-md-12"
                                                                type="text"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button href="#"
                                                                class="btn btn-primary note-btn note-btn-primary note-image-btn disabled"
                                                                disabled="">Insert Image
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal" aria-hidden="false" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span aria-hidden="true">×</span>
                                                        </button>
                                                        <h4 class="modal-title">Insert Video</h4></div>
                                                    <div class="modal-body">
                                                        <div class="form-group note-form-group row-fluid"><label
                                                                class="note-form-label">Video URL? <small
                                                                    class="text-muted">(YouTube, Vimeo, Vine, Instagram,
                                                                    DailyMotion or Youku)</small></label><input
                                                                class="note-video-url form-control  note-form-control note-input span12"
                                                                type="text"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button href="#"
                                                                class="btn btn-primary note-btn note-btn-primary  note-video-btn disabled"
                                                                disabled="">Insert Video
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal" aria-hidden="false" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span aria-hidden="true">×</span>
                                                        </button>
                                                        <h4 class="modal-title">Help</h4></div>
                                                    <div class="modal-body"
                                                         style="max-height: 300px; overflow: scroll;">
                                                        <div class="help-list-item"></div>
                                                        <label
                                                            style="width: 180px; margin-right: 10px;"><kbd>ENTER</kbd></label><span>Insert Paragraph</span>
                                                        <div class="help-list-item"></div>
                                                        <label
                                                            style="width: 180px; margin-right: 10px;"><kbd>CTRL+Z</kbd></label><span>Undoes the last command</span>
                                                        <div class="help-list-item"></div>
                                                        <label
                                                            style="width: 180px; margin-right: 10px;"><kbd>CTRL+Y</kbd></label><span>Redoes the last command</span>
                                                        <div class="help-list-item"></div>
                                                        <label style="width: 180px; margin-right: 10px;"><kbd>TAB</kbd></label><span>Tab</span>
                                                        <div class="help-list-item"></div>
                                                        <label
                                                            style="width: 180px; margin-right: 10px;"><kbd>SHIFT+TAB</kbd></label><span>Untab</span>
                                                        <div class="help-list-item"></div>
                                                        <label
                                                            style="width: 180px; margin-right: 10px;"><kbd>CTRL+B</kbd></label><span>Set a bold style</span>
                                                        <div class="help-list-item"></div>
                                                        <label
                                                            style="width: 180px; margin-right: 10px;"><kbd>CTRL+I</kbd></label><span>Set a italic style</span>
                                                        <div class="help-list-item"></div>
                                                        <label
                                                            style="width: 180px; margin-right: 10px;"><kbd>CTRL+U</kbd></label><span>Set a underline style</span>
                                                        <div class="help-list-item"></div>
                                                        <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+S</kbd></label><span>Set a strikethrough style</span>
                                                        <div class="help-list-item"></div>
                                                        <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+BACKSLASH</kbd></label><span>Clean a style</span>
                                                        <div class="help-list-item"></div>
                                                        <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+L</kbd></label><span>Set left align</span>
                                                        <div class="help-list-item"></div>
                                                        <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+E</kbd></label><span>Set center align</span>
                                                        <div class="help-list-item"></div>
                                                        <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+R</kbd></label><span>Set right align</span>
                                                        <div class="help-list-item"></div>
                                                        <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+J</kbd></label><span>Set full align</span>
                                                        <div class="help-list-item"></div>
                                                        <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+NUM7</kbd></label><span>Toggle unordered list</span>
                                                        <div class="help-list-item"></div>
                                                        <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+NUM8</kbd></label><span>Toggle ordered list</span>
                                                        <div class="help-list-item"></div>
                                                        <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+LEFTBRACKET</kbd></label><span>Outdent on current paragraph</span>
                                                        <div class="help-list-item"></div>
                                                        <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+RIGHTBRACKET</kbd></label><span>Indent on current paragraph</span>
                                                        <div class="help-list-item"></div>
                                                        <label
                                                            style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM0</kbd></label><span>Change current block's format as a paragraph(P tag)</span>
                                                        <div class="help-list-item"></div>
                                                        <label
                                                            style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM1</kbd></label><span>Change current block's format as H1</span>
                                                        <div class="help-list-item"></div>
                                                        <label
                                                            style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM2</kbd></label><span>Change current block's format as H2</span>
                                                        <div class="help-list-item"></div>
                                                        <label
                                                            style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM3</kbd></label><span>Change current block's format as H3</span>
                                                        <div class="help-list-item"></div>
                                                        <label
                                                            style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM4</kbd></label><span>Change current block's format as H4</span>
                                                        <div class="help-list-item"></div>
                                                        <label
                                                            style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM5</kbd></label><span>Change current block's format as H5</span>
                                                        <div class="help-list-item"></div>
                                                        <label
                                                            style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM6</kbd></label><span>Change current block's format as H6</span>
                                                        <div class="help-list-item"></div>
                                                        <label
                                                            style="width: 180px; margin-right: 10px;"><kbd>CTRL+ENTER</kbd></label><span>Insert horizontal rule</span>
                                                        <div class="help-list-item"></div>
                                                        <label
                                                            style="width: 180px; margin-right: 10px;"><kbd>CTRL+K</kbd></label><span>Show Link Dialog</span>
                                                    </div>
                                                    <div class="modal-footer"><p class="text-center"><a
                                                                href="http://summernote.org/" target="_blank">Summernote
                                                                0.8.8</a> · <a
                                                                href="https://github.com/summernote/summernote"
                                                                target="_blank">Project</a> · <a
                                                                href="https://github.com/summernote/summernote/issues"
                                                                target="_blank">Issues</a></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4"></label>
                                <div class="col-sm-8">
                                    <button type="submit" class="btn btn-success">Добавить</button>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <h3>Комментарии к работе:</h3>
                        <div class="work-comment-pagination pagination pagination-sm"></div>
                        <div id="work-comment"></div>
                        <div class="work-comment-pagination pagination pagination-sm"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Закрыть окно
                </button>
            </div>
        </div>
    </div>
</div>
