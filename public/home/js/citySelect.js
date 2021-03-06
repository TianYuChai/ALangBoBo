/**
 * Created by mzf on 2018/8/7.
 */
$(function(){
    addArray();
    //console.log(arr2);
    //加载省级列表
    for(let i=0;i<arr.length;i++) {
        $('.dropProvUl').append("<li class='dropProvLi'>" + arr[i] + "</li>");
    }
    //点击选择城市时，先隐藏省级市级选择块
    $('.citySelect').on('click',function(){
        //$('.dropDown').toggle();
        $('.dropCity').css('display',"none");
        $('.dropProv').toggle();
            //点击省份时，自动选择省会城市
            $('.dropProvLi').on('click',function(){
                $('.cityName').text( arr2[$(this).index()][0]);
                $('.dropDown div').css("display","none");
            });
            //给省级列表添加mouseover事件
            $('.dropProvLi').on('mouseover',function(){
                $('.dropCity').css("display","block");
                $('.dropProvLi').css("background-color","white");
                $('.dropCityUl').empty();
                $(this).css("background-color","#f1f3f6");
                //加载城市列表
                for(let j=0;j<arr2[$(this).index()].length;j++){
                    $('.dropCityUl').append("<li class='dropCityLi'>"+arr2[$(this).index()][j]+"</li>");

                }
                //选择城市
                $('.dropCityLi').on("click", function () {
                    //console.log($(this).text());
                    $('.cityName').text($(this).text());
                    $('.dropDown div').css("display","none");
                });
            });
    });
   // console.log(arr[17]);
});
//把市级添加到arr2中对应的省级
function addArray(){
     arr=["北京","天津","上海","重庆","河北","山西","内蒙古","辽宁","吉林","黑龙江","江苏","浙江","安徽","福建","江西","山东","河南","湖北","湖南","广东","广西","海南","四川","贵州","云南","西藏","陕西","甘肃","青海","宁夏","新疆","香港","澳门","台湾"];
     arr2=["北京","天津","上海","重庆","河北","山西","内蒙古","辽宁","吉林","黑龙江","江苏","浙江","安徽","福建","江西","山东","河南","湖北","湖南","广东","广西","海南","四川","贵州","云南","西藏","陕西","甘肃","青海","宁夏","新疆","香港","澳门","台湾"];
    function addTo(id,iArray){
        arr2[id] = [];
        for(let i=0;i<iArray.length;i++){
            arr2[id][i]=iArray[i];
        }

    }
   addTo("0",["北京"]);
   addTo("1",["天津"]);
   addTo("2",["上海"]);
   addTo("3",["重庆"]);
   addTo("4",["石家庄","张家口","承德","秦皇岛","唐山","廊坊","保定","衡水","沧州","邢台","邯郸"]);
   addTo("5",["太原","朔州","大同","阳泉","长治","晋城","忻州","晋中","临汾","吕梁","运城"]);
   addTo("6",["呼和浩特","包头","乌海","赤峰","通辽","呼伦贝尔","鄂尔多斯","乌兰察布","巴彦淖尔","兴安盟","锡林郭勒盟","阿拉善盟"]);
   addTo("7",["沈阳","朝阳","阜新","铁岭","抚顺","本溪","辽阳","鞍山","丹东","大连","营口","盘锦","锦州","葫芦岛"]);
   addTo("8",["长春","白城","松原","吉林","四平","辽源","通化","白山","延边州"]);
   addTo("9",["哈尔滨","齐齐哈尔","七台河","黑河","大庆","鹤岗","伊春","佳木斯","双鸭山","鸡西","牡丹江","绥化","大兴安岭"]);
   addTo("10",["南京","徐州","连云港","宿迁","淮安","盐城","扬州","泰州","南通","镇江","常州","无锡","苏州"]);
   addTo("11",["杭州","湖州","嘉兴","舟山","宁波","绍兴","衢州","金华","台州","温州","丽水"]);
   addTo("12",["合肥","宿州","淮北","亳州","阜阳","蚌埠","淮南","滁州","马鞍山","芜湖","铜陵","安庆","黄山","六安","巢湖","池州","宣城"]);
   addTo("13",["福州","南平","莆田","三明","泉州","厦门","漳州","龙岩","宁德"]);
   addTo("14",["南昌","九江","景德镇","鹰潭","新余","萍乡","赣州","上饶","抚州","宜春","吉安"]);
   addTo("15",["济南","青岛","聊城","德州","东营","淄博","潍坊","烟台","威海","日照","临沂","枣庄","济宁","泰安","莱芜","滨州","菏泽"]);
   addTo("16",["郑州","开封","三门峡","洛阳","焦作","新乡","鹤壁","安阳","濮阳","商丘","许昌","漯河","平顶山","南阳","信阳","周口","驻马店","济源"]);
   addTo("17",["武汉","十堰","襄阳","荆门","孝感","黄冈","鄂州","黄石","咸宁","荆州","宜昌","随州","仙桃","潜江","天门","神农架林区","恩施州"]);
   addTo("18",["长沙","张家界","常德","益阳","岳阳","株洲","湘潭","衡阳","郴州","永州","邵阳","怀化","娄底","湘西州"]);
   addTo("19",["广州","深圳","清远","韶关","河源","梅州","潮州","汕头","揭阳","汕尾","惠州","东莞","珠海","中山","江门","佛山","肇庆","云浮","阳江","茂名","湛江"]);
   addTo("20",["南宁","桂林","柳州","梧州","贵港","玉林","钦州","北海","防城港","崇左","百色","河池","来宾","贺州"]);
   addTo("21",["海口","三亚","文昌","琼海","万宁","五指山","东方","儋州","三沙"]);
   addTo("22",["成都","广元","绵阳","德阳","南充","广安","遂宁","内江","乐山","自贡","泸州","宜宾","攀枝花","巴中","达州","资阳","眉山","雅安","阿坝州","甘孜州","凉山州"]);
   addTo("23",["贵阳","六盘水","遵义","安顺","毕节","铜仁","黔东南州","黔南州","黔西南州"]);
   addTo("24",["昆明","曲靖","玉溪","保山","昭通","丽江","思茅","临沧","德宏州","怒江州","迪庆州","大理州","楚雄州","红河州","文山州","西双版纳"]);
   addTo("25",["拉萨","那曲","昌都","林芝","山南","日喀则","阿里"]);
   addTo("26",["西安","延安","铜川","渭南","咸阳","宝鸡","汉中","榆林","安康","商洛"]);
   addTo("27",["兰州","嘉峪关","白银","天水","武威","酒泉","张掖","庆阳","平凉","定西","陇南","临夏州","甘南州"]);
   addTo("28",["西宁","海东","海北州","海南州","黄南州","果洛州","玉树州","海西州"]);
   addTo("29",["银川","石嘴山","吴忠","固原","中卫"]);
   addTo("30",["乌鲁木齐","克拉玛依","喀什","阿克苏","和田","吐鲁番","哈密","克孜勒苏柯州","博尔塔拉州","昌吉州","巴音郭楞州","伊犁州","塔城","阿勒泰"]);
   addTo("31",["香港"]);
   addTo("32",["澳门"]);
   addTo("33",["台北","高雄","台中","花莲","基隆","嘉义","金门","连江","苗栗","南投","澎湖","屏东","台东","台南","桃园","新竹","宜兰","云林","彰化"]);
   // console.log(arr);
};

function comparison(str) {
    var arr = {account: '账号', password: '密码',
        name: '姓名', id: '身份证号', mobile: '手机号',
        verifyCode: '验证码',
        zheng: '身份证正面',fan: '身份证反面',shopName: '店名', shehuiDaima: '统一信用代码',
        yyzz: '营业执照', zuopin: '个人证件或作品上传'
    };

    return arr[str] == 'undefined' ? '' : '请填写' + arr[str];
}

// 验证手机号
function isPhoneNo(phone) {
    var pattern = /^1[34578]\d{9}$/;
    return pattern.test(phone);
}

// 验证身份证
function isCardNo(card) {
    var pattern = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
    return pattern.test(card);
}
var user = '用户服务协议<br>\n' +
    '一、协议双方<br>\n' +
    '本服务协议双方为阿郎博波文化传媒（深圳）有限公司（下称"阿郎博波"）与阿郎博波网用户，本服务协议具有合同效力。\n' +
    '本服务协议内容包括协议正文及所有阿郎博波已经发布的或将来可能发布的各类规则。所有规则为协议不可分割的一部分，与协议正文具有同等法律效力。\n' +
    '用户在使用阿郎博波商城网站提供的各项服务的同时，承诺接受并遵守各项相关规则的规定。阿郎博波有权根据需要不时地制定、修改本协议或各类规则，如本协议有任何变更，阿郎博波将在网站上刊载公告，通知予用户。如用户不同意相关变更，必须停止使用"服务"。经修订的协议一经在阿郎博波网公布后，立即自动生效。各类规则会在发布后生效，亦成为本协议的一部分。登录或继续使用"服务"将表示用户接受经修订的协议。除另行明确声明外，任何使"服务"范围扩大或功能增强的新内容均受本协议约束。\n' +
    '用户确认本服务协议后，本服务协议即在用户和阿郎博波之间产生法律效力。请用户务必在注册之前认真阅读全部服务协议内容，如有任何疑问，可向阿郎博波咨询。 1、无论用户事实上是否在注册之前认真阅读了本服务协议，只要用户点击协议正本下方的"确认"按钮并按照阿郎博波注册程序成功注册为用户，用户的行为仍然表示其同意并签署了本服务协议。 2、本协议不涉及用户与阿郎博波其它用户之间因网上交易而产生的法律关系及法律纠纷。<br>\n' +
    '二、 定义<br>\n' +
    '阿郎博波网上交易平台：有关阿郎博波网上交易平台上的术语或图示的含义，详见阿郎博波帮助\n' +
    '用户及用户注册：用户必须是具备完全民事行为能力的自然人，或者是具有合法经营资格的实体组织。无民事行为能力人、限制民事行为能力人以及无经营或特定经营资格的组织不当注册为阿郎博波用户或超过其民事权利或行为能力范围从事交易的，其与阿郎博波之间的服务协议自始无效，阿郎博波一经发现，有权立即注销该用户，并追究其使用阿郎博波网"服务"的一切法律责任。用户注册是指用户登陆阿郎博波网，并按要求填写相关信息并确认同意履行相关用户协议的过程。用户因进行交易、获取有偿服务或接触阿郎博波网服务器而发生的所有应纳税赋，以及一切硬件、软件、服务及其它方面的费用均由用户负责支付。阿郎博波网站仅作为交易地点。阿郎博波仅作为用户物色交易对象，就货物和服务的交易进行协商，以及获取各类与贸易相关的服务的地点。阿郎博波不能控制交易所涉及的物品的质量、安全或合法性，商贸信息的真实性或准确性，以及交易方履行其在贸易协议项下的各项义务的能力。阿郎博波提醒用户应该通过自己的谨慎判断确定登录物品及相关信息的真实性、合法性和有效性。 <br>\n' +
    '三、 用户权利和义务<br>\n' +
    '用户有权拥有自己在阿郎博波网的用户名及交易密码，并有权利使用自己的用户名及 密码随时登陆阿郎博波网交易平台。用户不得以任何形式擅自转让或授权他人使用自己的阿郎博波网用户名\n' +
    ' 用户有权根据本服务协议的规定以及阿郎博波网上发布的相关规则利用阿郎博波网上交易平台查询物品信息、发布交易信息、登录物品、参加网上物品竞买、与其它用户订立物品买卖合同、评价其它用户的信用、参加阿郎博波的有关活动以及有权享受阿郎博波提供的其它的有关信息服务 \n' +
    '用户在阿郎博波网上交易过程中如与其他用户因交易产生纠纷，可以请求阿郎博波从中予以协调。用户如发现其他用户有违法或违反本服务协议的行为，可以向阿郎博波进行反映要求处理。如用户因网上交易与其他用户产生诉讼的，用户有权通过司法部门要求阿郎博波提供相关资料； \n' +
    '用户有义务在注册时提供自己的真实资料，并保证诸如电子邮件地址、联系电话、联系地址、邮政编码等内容的有效性及安全性，保证阿郎博波及其他用户可以通过上述联系方式与自己进行联系。同时，用户也有义务在相关资料实际变更时及时更新有关注册资料。用户保证不以他人资料在阿郎博波网进行注册或认证； \n' +
    '用户应当保证在使用阿郎博波网网上交易平台进行交易过程中遵守诚实信用的原则，不在交易过程中采取不正当竞争行为，不扰乱网上交易的正常秩序，不从事与网上交易无关的行为； \n' +
    '用户不应在阿郎博波网网上交易平台上恶意评价其他用户，或采取不正当手段提高自身的信用度或降低其他用户的信用度； \n' +
    '用户在阿郎博波网网上交易平台上不得发布各类违法或违规信息； \n' +
    '用户在阿郎博波网网上交易平台上不得买卖国家禁止销售的或限制销售的物品、不得买卖侵犯他人知识产权或其它合法权益的物品，也不得买卖违背社会公共利益或公共道德的、或是阿郎博波认为不适合在阿郎博波网上销售的物品。具体内容详见禁止和限制发布商品信息规则； \n' +
    '用户承诺自己在使用阿郎博波网时实施的所有行为均遵守国家法律、法规和阿郎博波的相关规定以及各种社会公共利益或公共道德。如有违反导致任何法律后果的发生，用户将以自己的名义独立承担所有相应的法律责任； \n' +
    '用户同意，不对阿郎博波网上任何数据作商业性利用，包括但不限于在未经阿郎博波事先书面批准的情况下，以复制、传播等方式使用在阿郎博波网站上展示的任何资料； <br>\n' +
    '四、阿郎博波的权利和义务<br>\n' +
    '阿郎博波有义务在现有技术上维护整个网上交易平台的正常运行，并努力提升和改进技术，使用户网上交易活动得以顺利进行； \n' +
    '对用户在注册使用阿郎博波网上交易平台中所遇到的与交易或注册有关的问题及反映的情况，阿郎博波应及时作出回复； \n' +
    '对于用户在阿郎博波网网上交易平台上的不当行为或其它任何阿郎博波认为应当终止服务的情况，阿郎博波有权随时作出删除相关信息、终止服务提供等处理，而无须征得用户的同意； \n' +
    '因网上交易平台的特殊性，阿郎博波没有义务对所有用户的注册数据、所有的交易行为以及与交易有关的其它事项进行事先审查，但如存在下列情况： \n' +
    '1、用户或其它第三方通知阿郎博波，认为某个具体用户或具体交易事项可能存在重大问题；\n' +
    '2、用户或其它第三方向阿郎博波告知交易平台上有违法或不当行为的，阿郎博波以普通非专业交易者的知识水平标准对相关内容进行判别，可以明显认为这些内容或行为具有违法或不当性质的；\n' +
    '阿郎博波有权根据不同情况选择保留或删除相关信息或继续、停止对该用户提供服务，并追究相关法律责任。\n' +
    '用户在阿郎博波网上交易过程中如与其它用户因交易产生纠纷，请求阿郎博波从中予以调处，经阿郎博波审核后，阿郎博波有权通过电子邮件联系向纠纷双方了解情况，并将所了解的情况通过电子邮件互相通知对方； \n' +
    '用户因在阿郎博波网上交易与其它用户产生诉讼的，用户通过司法部门或行政部门依照法定程序要求阿郎博波提供相关数据，阿郎博波应积极配合并提供有关资料； \n' +
    '阿郎博波有权对用户的注册数据及交易行为进行查阅，发现注册数据或交易行为中存在任何问题或怀疑，均有权向用户发出询问及要求改正的通知或者直接做出删除等处理； \n' +
    '经国家生效法律文书或行政处罚决定确认用户存在违法行为，或者阿郎博波有足够事实依据可以认定用户存在违法或违反服务协议行为的，阿郎博波有权在阿郎博波交易平台及所在网站上以网络发布形式公布用户的违法行为； \n' +
    '对于用户在阿郎博波交易平台发布的下列各类信息，阿郎博波有权在不通知用户的前提下进行删除或采取其它限制性措施，包括但不限于以规避费用为目的的信息；以炒作信用为目的的信息；阿郎博波有理由相信存在欺诈等恶意或虚假内容的信息；阿郎博波有理由相信与网上交易无关或不是以交易为目的的信息；阿郎博波有理由相信存在恶意竞价或其它试图扰乱正常交易秩序因素的信息；阿郎博波有理由相信该信息违反公共利益或可能严重损害淘宝和其它用户合法利益的； \n' +
    '用户完成阿郎博波网注册后，将会获得一个阿郎博波账户。<br>\n' +
    '五、服务的中断和终止<br>\n' +
    '用户同意，在阿郎博波未向用户收取服务费的情况下，阿郎博波可自行全权决定以任何理由 (包括但不限于阿郎博波认为用户已违反本协议的字面意义和精神，或以不符合本协议的字面意义和精神的方式行事，或用户在超过90天的时间内未以用户的账号及密码登录网站等) 终止用户的"服务"密码、账户 (或其任何部份) 或用户对"服务"的使用，并删除（不再保存）用户在使用"服务"中提交的任何资料。同时阿郎博波可自行全权决定，在发出通知或不发出通知的情况下，随时停止提供"服务"或其任何部份。账号终止后，阿郎博波没有义务为用户保留原账号中或与之相关的任何信息，或转发任何未曾阅读或发送的信息给用户或第三方。此外，用户同意，阿郎博波不就终止用户接入"服务"而对用户或任何第三者承担任何责任； \n' +
    '如用户向阿郎博波提出注销阿郎博波网注册用户身份时，经阿郎博波审核同意，由阿郎博波注销该注册用户，用户即解除与阿郎博波的服务协议关系。但注销该用户账号后，阿郎博波仍保留下列权利： \n' +
    '1、用户注销后，阿郎博波有权保留该用户的注册数据及以前的交易行为记录。\n' +
    '2、用户注销后，如用户在注销前在阿郎博波交易平台上存在违法行为或违反合同的行为，阿郎博波仍可行使本服务协议所规定的权利；\n' +
    '在下列情况下，阿郎博波可以通过注销用户的方式终止服务： \n' +
    '1、在用户违反本服务协议相关规定时，阿郎博波有权终止向该用户提供服务。阿郎博波将在中断服务时通知用户。但如该用户在被阿郎博波终止提供服务后，再一次直接或间接或以他人名义注册为阿郎博波用户的，阿郎博波有权再次单方面终止向该用户提供服务；\n' +
    '2、如阿郎博波通过用户提供的信息与用户联系时，发现用户在注册时填写的电子邮箱已不存在或无法接收电子邮件的，经阿郎博波以其它联系方式通知用户更改，而用户\n' +
    '在三个工作日内仍未能提供新的电子邮箱地址的，阿郎博波有权终止向该用户提供服务；\n' +
    '3、一旦阿郎博波发现用户注册数据中主要内容是虚假的，阿郎博波有权随时终止向该用户提供服务；\n' +
    '4、本服务协议终止或更新时，用户明示不愿接受新的服务协议的；\n' +
    '5、其它阿郎博波认为需终止服务的情况。\n' +
    '服务中断、终止之前用户交易行为的处理因用户违反法律法规或者违反服务协议规定而致使阿郎博波中断、终止对用户服务的，对于服务中断、终止之前用户交易行为依下列原则处理： \n' +
    '1、服务中断、终止之前，用户已经上传至阿郎博波网的物品尚未交易或尚未交易完成的，阿郎博波有权在中断、终止服务的同时删除此项物品的相关信息；\n' +
    '2、服务中断、终止之前，用户已经就其它用户出售的具体物品作出要约，但交易尚未结束，阿郎博波有权在中断或终止服务的同时删除该用户的相关要约；\n' +
    '3、服务中断、终止之前，用户已经与另一用户就具体交易达成一致，阿郎博波可以不删除该项交易，但阿郎博波有权在中断、终止服务的同时将用户被中断或终止服务的情况通知用户的交易对方。<br>\n' +
    '六、责任范围<br>\n' +
    '用户明确理解和同意，阿郎博波不对因下述任一情况而导致的任何损害赔偿承担责任，包括但不限于利润、商誉、使用、数据等方面的损失或其它无形损失的损害赔偿 (无论阿郎博波是否已被告知该等损害赔偿的可能性)： \n' +
    '使用或未能使用"服务；\n' +
    '第三方未经批准的接入或第三方更改用户的传输数据或数据；\n' +
    '第三方对"服务"的声明或关于"服务"的行为；或非因阿郎博波的原因而引起的与"服务"有关的任何其它事宜，包括疏忽。\n' +
    '用户明确理解并同意，如因其违反有关法律或者本协议之规定，使阿郎博波遭受任何损失，受到任何第三方的索赔，或任何行政管理部门的处罚，用户应对阿郎博波提供补偿，包括合理的律师费用。 <br>\n' +
    '七、隐私权政策适用范围： <br>\n' +
    '①在用户注册阿郎博波账户时，用户根据阿郎博波要求提供的个人注册信息；\n' +
    '②在用户使用阿郎博波服务，参加阿郎博波活动，或访问阿郎博波网页时，阿郎博波自动接收并记录的用户浏览器上的服务器数值，包括但不限于IP地址等数据及用户要求取用的网页记录；\n' +
    '③阿郎博波收集到的用户在阿郎博波进行交易的有关数据，包括但不限于出价、购买、物品登录、信用评价及违规记录；\n' +
    '④阿郎博波通过合法途径从商业伙伴处取得的用户个人数据。\n' +
    '信息使用： \n' +
    '①阿郎博波不会向任何人出售或出借用户的个人信息，除非事先得到用户得许可。\n' +
    '②阿郎博波亦不允许任何第三方以任何手段收集、编辑、出售或者无偿传播用户的个人信息。任何用户如从事上述活动，一经发现，阿郎博波有权立即终止与该用户的服务协议，查封其账号。 \n' +
    '③为服务用户的目的，阿郎博波可能通过使用用户的个人信息，向用户提供服务，包括但不限于向用户发出产品和服务信息，或者与阿郎博波合作伙伴共享信息以便他们向用户发送有关其产品和服务的信息（后者需要用户的事先同意）。\n' +
    '信息披露：\n' +
    '用户的个人信息将在下述情况下部分或全部被披露：\n' +
    '①经用户同意，向第三方披露； \n' +
    '②如用户是资格的知识产权投诉人并已提起投诉，应被投诉人要求，向被投诉人披露，以便双方处理可能的权利纠纷；\n' +
    '③根据法律的有关规定，或者行政或司法机构的要求，向第三方或者行政、司法机构披露；\n' +
    '④如果用户出现违反中国有关法律或者网站政策的情况，需要向第三方披露；\n' +
    '⑤为提供你所要求的产品和服务，而必须和第三方分享用户的个人信息；\n' +
    '⑥其它阿郎博波根据法律或者网站政策认为合适的披露；\n' +
    '⑦在阿郎博波网上创建的某一交易中，如交易任何一方履行或部分履行了交易义务并提出信息披露请求的， 阿郎博波有全权可以决定向该用户提供其交易对方的联络方式等必要信息，以促成交易的完成或纠纷的解决。\n' +
    '信息安全： \n' +
    '①阿郎博波账户均有密码保护功能，请妥善保管用户的账户及密码信息； \n' +
    '②在使用阿郎博波服务进行网上交易时，用户不可避免的要向交易对方或潜在的交易对方提供自己的个人信息，如联络方式或者邮政地址。请用户妥善保护自己的个人信息，仅在必要的情形下向他人提供；\n' +
    '③如果用户发现自己的个人信息泄密，尤其是阿郎博波账户及密码发生泄露，请用户立即联络阿郎博波客服，以便阿郎博波采取相应措施。\n' +
    '编辑和删除个人信息的权限： 用户可以点击我的阿郎博波对用户的个人信息进行编辑和删除，除非阿郎博波另有规定。 \n' +
    '政策修改：阿郎博波保留对本政策作出不时修改的权利。<br>\n' +
    '管辖：\n' +
    '本服务条款之解释与适用，履行本协议过程中产生的任何争议，双方应协商解决，协商不成的，可向本协议签署地人民法院提起诉讼。';

var business = '商家入住协议<br>\n' +
    '商家必读<br>\n' +
    '甲方：阿郎博波文化传媒（深圳）有限公司（即阿郎博波商城网站）<br>\n' +
    '乙方：商家（指符合后台审核通过可以在网站发布产品的企业或个人）<br>\n' +
    '1，商家费用说明：用本网站缴纳的费用为年费（可以选择按月缴纳），以及不同行业单笔成功交易后所规定的服务费，（每个行业线下签合同的比例为准，线上不产生交易）充值和体现的费用（1000元以上的费率0.6%，1000以下的0.6%+每笔一元的手续费），三项基本费用外，其他可以选择行付费。选择行付费的选择，区域加盟承包费，区域直营承包费，同行业网络广告位承包费等，具体以商家和平台签合同为准。\n' +
    '<br>2，商家造到客户投诉，经核实，上黑名单，商家和顾客协议解决，移除黑名单，手续费100元商家付，顾客和平台各分得50元。\n' +
    '<br>3，商品质量，数量等硬性条件不符买家要求（颜色光泽除外）拒绝退款，经核实，经双方解决后，移除黑名单，手续费100元，罚款100元，平台和买家各分得100元。\n' +
    '<br>4，买家和商家蓄意刷单，经核实，第一次罚款500元，第二次2500元，第三次关店（时间2个月以上），罚款归平台所有。\n' +
    '<br>5，商家举报买家逾期，商家和顾客协议解决，移除黑名单，手续费100元买家付，商家和平台各分得50元。\n' +
    '<br>6，买家蓄意捣乱，商家举报，经核实，经双方解决，买家罚款100元，移除黑名单，手续费100元，商家和平台各得100元。\n' +
    '<br>7，商家可以选择发货方式为，   付实缴发货（即，将货物的商品价付到平台上，等买家确认收货后，平台支付到商家账户），     认缴发货，（即买家付一定的信用保证金，商家发货，特别提醒，信誉保证金是计算总的货物价不单包单一店铺的商品，买家逾期或逃单，信用保正金只能赔付第一个下单购买的商家，买家结清货款，移除黑名单的手续费归第一个举报商家和平台所有。举例：买家付100元信用保证金，可以购买的商品总额是1000元以内，买家分5价店购买，如果买家一旦逃单，信用保证金只能赔付第一商家，如果你是第二家或者其他第几家，你将得不到任何赔偿，但你可以举报买家上黑名单），当买家结清货款后，移除黑名单，第一个举报商家和平台平分移除黑名单的手续费。\n' +
    '<br>8，定制商品和代办服务和餐饮类等，餐饮类，商家接单已完成，商家不退回成本价，由于配送人员超时配送的原因造成买家拒绝付款，由配送人员自行负担商家货款，饮品类已使用的不退货，不退款，未使用的可以，发现问题，商家按购买价格退还，商家完成产品，颜色差异等问题不属于商家退货理由，如遇到顾客退货退款，商家只退满意价，商家成本价该不退还，满意度损失由顾客自己承担。\n' +
    '<br>9， 期货产品，买家用信用保证金或全款购买的商品，存在商家库房或寄存在商家处，寄存费商家和顾客协议解决，遇到买家找理由要求商家回购商品，拒绝付清尾款，或不提走货物，也不交寄存费等，本平台支持商家不退款不回购商品决定。\n' +
    '<br>10，本平台所有合作者，只挣的干干净净的钱，只挣合适的钱，如果发现通过贿赂等手段拿到不属于自己的利益，合作者上黑名单，公示五天后，永远解决合作关系，本平台或本公示员工立即开除，永不录用。\n' +
    '<br>11，直营店和加盟店加盟费按年交付，未满一年，按一年算，加盟费和直营费用当年的未满，按一年结清，其余的退还。\n' +
    '<br>12，商家的单笔交易与本平台利润分配，采用线下签合同的方式完成，以合同为准，本平台所得的利润，商家可采取后台服务费的方式线上缴纳，也可用其他方式缴纳，未准时缴纳，本平台有权以滞纳金款和关店的形式予以处罚，商家和买家的黑名单手续费也可采用后台服务费或其他方式缴纳。\n' +
    '<br>13.提供的资料虚假，地址联系不到，会上黑名单或这关店。\n' +
    '<br>14买家购买商家期货产品并寄存在商家处授权商家代售，商家不收买家交易服务费，买家购买的顺序就是商家优先预售的顺序，商家应该从预售商品日起，先预售买家商品，最后再出售自己的产品，用信用保证金购买的商品商家代售成功后自动抵扣买家的货款，将授权期间多余的利润和商品返还购买预售商品的买家，授权期限买家和商家协议解决，售卖价格在购买预售商品的买家未定价格前，不得低于预售商品购买时候的价格，购买预售商品的买家已定价，价格达到标准，售出的每件商品货款归预售买家所有，相同定价预售的购买商品买家预售商品的顺序按照购买的顺序预售，预售买家商品已售完，归商家自己所有，商家自己的商品可以自行决定，不受已购买预售买家定价的影响，预售期限和价格协议采用线下合同为准，线上不参与其营销方案，货款结算可以采用线上或其他方式结算。\n' +
    '<br>15，所有参加本平台商家自愿接受以上条例以及遭到投诉上黑名单和接受处罚的决定。\n' +
    '\n' +
    '<br>本协议由缔约双方在自愿、平等、公平及诚实信用原则的基础上，根据《中华人民共和国合同法》等相关法律、法规的规定，经友好协商缔结。\n' +
    '<br>一、合作方式\n' +
    '<br>1.1商城合作行式：\n' +
    '本协议所称合作，指由甲方所有并运营的“阿郎博波网站商城”提供电子商务平台并代收货款、由乙方提供商品并在甲方平台展示，同时由乙方自行向终端消费者提供商品、物流配送、售后服务等，双方联合经营的经营模式。\n' +
    '<br>1.1.1 甲方平台：指由甲方提供技术支持和服务的电子商务网站，由甲方提供技术服务或运营的移动端交易平台（包括但不限于甲方网APP、甲方PC平台等）。随着甲方服务范围或服务项目的变更，甲方可能在平台规则或公告中对甲方平台的范围或域名调整予以声明。\n' +
    '<br>1.1.2 商品：指在甲方平台上销售或展示的商品和服务。 \n' +
    '<br>1.1.3 商家：指在甲方平台上出售或提供商品的用户（商标持有人资质等公司性质企业）或经平台后台审核通过的并签署个人商家协议的自然人。\n' +
    '<br>1.14 商家注册：商家注册指欲成为“阿郎博波商城网站平台”第三方经营者的商家，依据“阿郎博波商城网站平台”入驻流程和要求完成在线信息提交，经“阿郎博波商城网站平台”审核同意后，开展经营活动；\n' +
    '<br>1.15 商家入驻：指第三方经营者完成商家注册，通过资质审核且满足本协议入驻服务开通条件后成为“阿郎博波商城网站平台”第三方经营者的过程；本协议中的商家指本协议缔约方中的“乙方”。\n' +
    '<br>1.1.6 商家后台：商家在甲方平台经甲方审核及完成必要的入驻流程后，由甲方给予商家PC端的商家管理后台网址，包括独立的账号和平台设置的初始密码，商家在该后台完成产品编辑、上传、设置运费、处理订单、申请提现等相关事宜。\n' +
    '<br>1.17 确认交易：指消费者（买家）在本网站平台向乙方购买商品，通过商城提供之后台系统付款并确认收货的交易。\n' +
    '<br>1.18 交易服务费：指甲方根据交易的商品价款向乙方收取的费用，此费用不包括网上支付设计的银行等交易的手续费，也不涉及商品配送所产生的物流快递费用，也不包括因违规产生的处罚费用。\n' +
    '<br>第二条 入驻条件及证明文件提交\n' +
    '\n' +
    '<br>2.1 入驻条件\n' +
    '<br>乙方申请成为“阿郎博波商城网站平台”入驻商家，在“阿郎博波商城网站平台”开展经营活动，须满足以下条件：\n' +
    '<br>　（1） 乙方已依照中华人民共和国法律注册并领取合法有效的营业执照及其他经营许可；\n' +
    '<br>　（2）乙方申请经营的商品或服务合法，资质齐全；\n' +
    '<br>　（3）乙方同意本协议及阿郎博波商城网站平台相关规则。\n' +
    '<br>（4）经后台审核可以并签署商家入住协议的商家。\n' +
    '<br>2.2 证明文件提交\n' +
    '<br>2.2.1 乙方须根据阿郎博波商城网站平台相关规则及要求向甲方提交证明文件或其他相关证明，包括但不限于营业执照、税务登记证、授权委托书、商标注册证、质检报告、报关单、检验检疫证书、产品来源地证明等。\n' +
    '<br>2.2.2 乙方保证向甲方提供的上述证明文件或其他相关证明真实、合法、准确、有效，并保证上述证明文件或其他相关证明发生任何变更或更新时，及时通知甲方，若上述文件变更或更新导致乙不符合本协议所规定入驻条件的，甲方有权单方全部或部分限制乙方经营，直至终止本协议。\n' +
    '<br>2.2.3 乙方对其提交的证明文件或其他相应证明的真实性、合法性、准确性、有效性承担全部法律责任，若因乙方提交虚假、过期文件或未及时更新或通知证明文件导致纠纷或被相关国家机关处罚的，由乙方独立承担全部法律责任，如因此造成阿郎博波商城网站损失的，乙方应予以赔偿。\n' +
    '<br>第四条 服务开通及停止\n' +
    '<br>3.1 对于乙方拟开展经营的特定主页，甲方在乙方提出入驻申请并满足以下条件后3个工作日内为乙方开通服务，甲方将在服务正式开通前一个工作日以邮件方式通知乙方。\n' +
    '<br>3.2 甲方为乙方开通服务后，乙方可利用阿郎博波商城网站平台注册邮箱及自设密码登陆商家后台，根据阿郎博波商城网站平台相关规则及流程向乙方特定主页上传、发布商品信息，与甲方业务员交流达成合作，使用本协议约定的其他有偿服务等。\n' +
    '<br>3.3 乙方店铺服务的停止：\n' +
    '<br>3.3.1 乙方需要停止服务的，应至少提前10个工作日向甲方提出申请，经甲方审核同意后由甲方停止服务功能；为弥补甲方已投入的人力、物力和技术支持，乙方同意甲方不退还对应的技术服务费；\n' +
    '<br>4.3.2 出现以下任一情形时，甲方有权随时停止乙方相关服务；\n' +
    '<br>4.3.2.1 乙方不满足入驻条件的；\n' +
    '<br>4.3.2.2 乙方提供虚假资质文件的；\n' +
    '<br>4.3.2.3 乙方产品质量、标识不合格的，或者产品涉嫌走私、假冒伪劣的；\n' +
    '<br>4.3.2.4 未经甲方事先审核产品品牌，而上传某品牌商品的；\n' +
    '<br>4.3.2.5 其他违反本协议约定或阿郎博波商城网站平台规则的；\n' +
    '\n' +
    '<br>第五条 费用及结算\n' +
    '\n' +
    '<br>5.1 乙方应按照本协议中确定的标准及支付方式向阿郎博波商城网站平台及阿郎博波商城网站平台业务员支付下述费用：\n' +
    '<br>5.1.1 技术服务费\n' +
    '<br>1) 乙方应按照约定的费用标准和时间向“阿郎博波商场网站平台”指定账户支付技术服务费，技术服务费按年/月缴纳；\n' +
    '<br>2) 乙方服务续展的，乙方应在续展期开始日前缴纳续展期间技术服务费。\n' +
    '<br>3) 乙方向甲方支付的技术服务费，除乙方的公司在签定本协议30个工作日内被依法被注销外，其他情况不予以退款。\n' +
    '<br>5.2 甲乙双方按照下述约定对乙方在“阿郎博波商城网站平台”经由甲方业务员成交的订单进行结算提成：\n' +
    '<br>5.2.1 提成/佣金\n' +
    '<br>提成/佣金结算完成，乙方应在15个工作日内支付到甲方业务员。\n' +
    '<br>结算的方式可以采取购买网站后台服务费的方式或者其他方式结算。\n' +
    '<br>第六条 保密\n' +
    '<br>6.1 甲乙双方对于本协议的签订、内容及在履行本协议期间所获知的另一方的商业秘密负有保密义务。非经对方书面同意，任何一方不得向第三方（关联公司除外）泄露、给予或转让该等保密信息。（根据法律、法规、证券交易所规则向政府、证券交易所和/或其他监管机构提供、双方的法律、会计、商业及其他顾问、雇员除外）。\n' +
    '<br>6.2 如对方提出要求，任何一方均应将载有对方保密信息的任何文件、资料或软件等，在本协议终止后按对方要求归还对方，或予以销毁，或进行其他处置，并且不得继续使用这些保密信息。\n' +
    '<br>6.3 在本协议终止之后，各方在本条款项下的义务并不随之终止，各方仍需遵守本协议之保密条款，履行其所承诺的保密义务，直到其他方同意其解除此项义务，或事实上不会因违反本协议的保密条款而给其他方造成任何形式的损害时为止。\n' +
    '<br>6.4 任何一方均应告知并督促其因履行本协议之目的而必须获知本协议内容及因合作而获知对方商业秘密的雇员、代理人、顾问等遵守保密条款，并对其雇员、代理人、顾问等的行为承担责任。  \n' +
    '<br>第七条 违约责任\n' +
    '<br>7.1 乙方向甲方提供虚假、失效的证明文件或其他相关证明，在“阿郎博波商城网站平台”发布错误、虚假、违法及不良信息或进行其他违反本协议约定的行为，给甲方及/或“阿郎博波商城网站平台”造成任何损失的（损失包括但不限于诉讼费、律师费、赔偿、补偿、行政机关处罚、差旅费等），乙方同意甲方未结算货款中直接予以扣除，本协议另有约定的除外。\n' +
    '<br>7.2 乙方发生违反本协议及阿郎博波网站平台规则的情形时，甲方除有权按照本条约定要求乙方承担违约责任外，还有权按照“阿郎博波网站平台”相关管理规则采取商品立即下架、暂停向乙方提供服务、暂时关闭乙方后台管理账户、暂缓支付未结算款项、终止合作等措施。\n' +
    '<br>第八条 有限责任及免责\n' +
    '<br>8.1 不论在何种情况下，甲方均不对由于电力、网络、电脑、通讯或其他系统的故障、罢工（含内部罢工或劳工骚乱）、劳动争议、暴乱、起义、骚乱、生产力或生产资料不足、火灾、洪水、风暴、爆炸、战争、政府行为等不可抗力，国际、国内法院的命令或第三方的不作为而造成的不能服务或延迟服务承担责任。\n' +
    '<br>8.2 本协议项下服务将按“现状”和按“可得到”的状态提供，甲方在此明确声明对服务不作任何明示或暗示的保证，包括但不限于对服务的可适用性、没有错误或疏漏、持续性、准确性、可靠性、适用于某一特定用途。\n' +
    '<br>8.3 使用“阿郎博波商城网站平台”服务下载或者获取任何资料的行为均出于乙方的独立判断，并由其自行承担因此而可能产生的风险和责任。\n' +
    '<br>8.4 不可抗力处理：如本协议履行期间，甲乙双方任何一方遭受不可抗力，均应在遭受不可抗力后尽快通知对方，并于通知之日起 15 日内提供相关证明文件，不可抗力持续达到三十日的，任一方有权经通知对方提前终止本协议。因不可抗力原因而导致本协议中止、终止的，双方均不须向对方承担违约责任。\n' +
    '<br>第九条 协议有效期\n' +
    '<br>9.1 本协议自双方签署后成立，持续对缔约双方有效，除非发生本协议所述的终止或解除事项。\n' +
    '<br>9.2 本协议中约定的服务期届满前一个月，如乙方愿意在服务期届满后继续使用甲方提供的服务，应向甲方提出相应续展服务期的申请并按约定缴纳下一年度的技术服务费，且经甲方审核通过后，进入新的服务期，否则，服务期届满后甲方将停止向乙方提供相应的服务，在甲方停止提供服务后 1 个月内，若乙方仍未完成新的服务期申请程序，则本协议有效期自乙方服务期满 1 个月后终止.\n' +
    '<br>第十条 协议的变更\n' +
    '<br>10.1 本协议其他条款变更或增加新的条款的，均须经缔约双方协商同意并签署书面补充协议，补充协议一经签署，即构成本协议的组成部分，与本协议具有同等法律效力。\n' +
    '<br>第十一条 通知及送达\n' +
    '<br>11.1 一方发给另一方的与本协议有关的通知应以书面形式送达，或以传真、电报、电传、电子邮件等发送。以传真、电报、电传或电子邮件发送的，发送当日为送达日，以邮资预付的挂号信件，特快专递寄送的，签收日为送达日。\n' +
    '<br>第十二条 争议解决\n' +
    '<br>11.1 履行本协议过程中产生的任何争议，双方应协商解决，协商不成的，可向本协议签署地人民法院提起诉讼。\n' +
    '\n' +
    '<br>11.2 本协议的签订、解释、变更、履行及争议的解决等均适用中华人民共和国现行有效的法律。\n' +
    '<br>第十六条 其他约定\n' +
    '<br>12.1 本协议的任何一方未能及时行使本协议项下的权利不应被视为放弃该权利，也不影响该方在将来行使该权利。\n' +
    '<br>12.2 如果本协议中的任何条款无论因何种原因完全或部分无效或不具有执行力，或违反任何适用的法律，则该条款被视为删除。但本协议的其余条款仍应有效并且有约束力。\n' +
    '<br>12.3 本协议是缔约双方之间关于本协议中提及合作事项的完整的、唯一的协议，本协议取代了任何先前的关于该合作事项的协议和沟通（包括书面形式和口头形式）。';


