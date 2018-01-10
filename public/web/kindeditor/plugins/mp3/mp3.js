KindEditor.plugin('mp3', function(K) {

    var self = this, name = 'mp3',lang = self.lang(name + '.'),
        allowMediaUpload = K.undef(self.allowMediaUpload, true),
        allowFileManager = K.undef(self.allowFileManager, false),
        formatUploadUrl = K.undef(self.formatUploadUrl, true),
        extraParams = K.undef(self.extraFileUploadParams, {}),
        filePostName = K.undef(self.filePostName, 'imgFile'),
        uploadJson = K.undef(self.uploadJson, self.basePath + 'php/upload_json.php');

    // 点击图标时执行
    self.clickToolbar(name, function() {
        var dialog = self.createDialog({
            width : 500,
            title : '插入音乐',
            body : "<div style=\"margin:10px;\"><input placeholder=\"歌曲名\"  type=\"text\" id=\"mp3Name\"  value=\"\" style=\"width:80%;\" /><br><input placeholder=\"歌曲url\"   type=\"text\" name=\"url\" value=\"\" style=\"width:80%;\" /><br><input type=\"button\" class=\"ke-upload-button\" value=\"选择音乐文件\" /></div>",
            closeBtn : {
                name : '关闭',
                click : function(e) {
                    self.hideDialog();
                }
            },
            yesBtn : {
                name : '确定',
                click : function(e) {
                    var str = "<div style=\"height:70px;width:70%;max-width:700px;min-width:300px;border:1px solid #eee;background: #fafafa;padding:10px;margin:5px 0;border-radius:1px;box-shadow: 5px 5px 5px #888888;position:relative\" >\n" +
                        "        <div style=\"padding-left:10px;color:#333;float:left;font-size:16px;\">"+mp3Name.val()+"</div>\n" +
                        "        <div style=\"float: right;margin-right:10px;margin-top:0px;color:#aaa\">徒哪儿网</div>\n" +
                        "        <audio style=\"width:80%;background:red !important;\"  src="+urlBox.val()+"  preload=\"preload\" loop=\"loop\" controls=\"controls\"></audio>\n" +
                        "   <span style='clear:both' ></span></div>";
                    self.insertHtml(str);
                    self.hideDialog();
                }
            },
            noBtn : {
                name : '取消',
                click : function(e) {
                    self.hideDialog();
                }
            }
        });
        var urlBox = K('[name="url"]');
        var mp3Name = K('#mp3Name');
        var uploadbutton = K.uploadbutton({
            button : K('.ke-upload-button')[0],
            fieldName : filePostName,
            extraParams : extraParams,
            url : K.addParam(uploadJson, 'dir=media'),
            afterUpload : function(data) {
                dialog.hideLoading();
                if (data.error === 0) {
                    var url = data.url;
                    if (formatUploadUrl) {
                        url = K.formatUrl(url, 'absolute');
                    }
                    urlBox.val(url);
                    if (self.afterUpload) {
                        self.afterUpload.call(self, url, data, name);
                    }
                    // alert(self.lang('uploadSuccess'));
                } else {
                    alert(data.message);
                }
            },
            afterError : function(html) {
                dialog.hideLoading();
                self.errorDialog(html);
            }
        });
        uploadbutton.fileBox.change(function(e) {
            dialog.showLoading(self.lang('uploadLoading'));
            uploadbutton.submit();
        });
    });
});