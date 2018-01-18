KindEditor.plugin('mp4', function(K) {

    var self = this, name = 'mp4',lang = self.lang(name + '.'),
        allowMediaUpload = K.undef(self.allowMediaUpload, true),
        allowFileManager = K.undef(self.allowFileManager, false),
        formatUploadUrl = K.undef(self.formatUploadUrl, true),
        extraParams = K.undef(self.extraFileUploadParams, {}),
        filePostName = K.undef(self.filePostName, 'imgFile'),
        uploadJson = K.undef(self.uploadJson, self.basePath + 'php/upload_json.php');

    // 点击图标时执行
    self.clickToolbar(name, function() {
        // alert("123"); return;
        var dialog = self.createDialog({
            width : 500,
            title : '插入视频',
            body : "<div style=\"margin:10px;\"><input placeholder=\"视频url\"   type=\"text\" name=\"url\" value=\"\" style=\"width:80%;\" /><br><input type=\"button\" class=\"ke-upload-button\" value=\"选择视频文件\" /></div>",
            closeBtn : {
                name : '关闭',
                click : function(e) {
                    self.hideDialog();
                }
            },
            yesBtn : {
                name : '确定',
                click : function(e) {
                    var str = "<video style=\"width:90%;\"  src="+urlBox.val()+"  preload=\"preload\" loop=\"loop\" controls=\"controls\"></video>";
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