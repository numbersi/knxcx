<!doctype html>
<html lang="zh_cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$data->name }}--{{$data->vod_remarks}}</title>
    <link href="https://cdn.bootcss.com/dplayer/1.22.2/DPlayer.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/hls.js/0.9.1/hls.js"></script>
    <script src="https://cdn.bootcss.com/dplayer/1.22.2/DPlayer.min.js"></script>
    <style>
        #erweima{
            width: 60%;
            height: 60%;
        }
    </style>
</head>
<body>
    <div>
        <p>关注公众号,看更多视频 \#长按识别二维码#\
        </p>
        <img id = 'erweima' src="/img/飞鸟二维码.jpg" alt="飞鸟TV">
    </div>
    <p>##请不要相信视频内部滚动广告,如若受骗,概不受骗.##</p>
<div id="dplayer"></div>
    <div>

<span style="font-size:12px;"><font color="red">注:1、</font><font color="#3366ff">本站资源介绍均由机器人自动采集提供，所有资源的实际视频文件都只保存在网友自己的计算机上。本站不会保存、复制或传播任何视频文件，也不对本站上的任何内容负法律责任。
<br>
<font color="red">注:2、</font>本站重视知识产权保护，并制定了旨在保护权利人的合法权益的措施和步骤，当权利人发现在本站的内容侵犯其著作权时，请权利人向本站发出书面“权利通知”，本站将依法采取措施移除相关内容或断开相关链接。</font></span>
    </div>
<script>
    const dp = new DPlayer({
        container: document.getElementById('dplayer'),
        autoplay: false,
        theme: '#FADFA3',
        loop: true,
        lang: 'zh-cn',
        screenshot: true,
        hotkey: true,
        preload: 'auto',
        volume: 0.7,
        mutex: true,
        video: {
            url: '{{$data->url}}',
            type: 'hls',
            pic:''
        },
        contextmenu: [
        ]
    });
</script>
</body>
</html>