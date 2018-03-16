=== Plugin Name ===
Contributors: beomps, daum
Donate link: http://beomps.com/
Tags: postcode, korea, address, search, beomps, daum, 도로명, 주소, 우편번호, 검색, 다음
Requires at least: 4.2.3
Tested up to: 4.8
Stable tag: 3.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

우커머스의 한국형 도로명 주소/우편번호 검색 플러그인 입니다. 

== Description ==
*Bug fixed. - 우커머스 업데이트 이후, 한글 번역이 마지막에 해당 라벨 필드값으로 덮어지도록 변경됐습니다. 이에따라 ‘우편번호 찾기’버튼이 노출되지 않아 큰 문제가 있었습니다. 임시로 상세주소 윗 라벨에 버튼을 추가하였습니다. 또한 다음 api 주소 변경 처리하였습니다. 버그 리포팅해주신, @최진욱님 감사합니다.

*Bug fixed. - Ajax 사용시 php 공백 문제 수정. 버그 리포팅해주신, @changwoo님 감사합니다.

관리자 페이지가 추가되었습니다. 지난 2.0 작업 이후 코드라인으로 변경해야 했던 부분들에 대해 관리자 페이지에서 수정 가능합니다.
-프로토콜 타입 선택가능(기본 값은 http)
-우편번호 5자리/6자리 선택가능
-우편번호 찾기 버튼명 변경가능
-청구/배송 주소의 기본 우커머스 입력 필드 표시가능(기본 값은 필수적이지 않은 입력부분 미표시 설정입니다.)
-기부 기능 추가
-우커머스 계정 페이지에 청구/배송 주소에 우편번호 검색 버튼 추가(의견사항)

*어드민 설정 페이지가 생김으로써, 구버젼의 소스코드 라에서 변경하셨던 부분은 다시 설정을 해주셔야합니다. 업데이트 이후 필히 확인부탁드립니다.
*다음 업데이트 기능은 몇몇 특정 웹브라우져(카카오톡내 웹브라우져, 네이버 앱 웹브라우져 등)에서 팝업 문제가 발생한다는 의견이 있어, 검색 부분을 Ajax와 iframe or div값을 이용하여 창 전환 없이 검색기능 추가할 예정입니다. 
*많은 분들이 관심가져주셔서 감사드리며, 사용시 생기는 문제나 의견 사항은 (https://www.beomps.com/forums/forum/forum/beomps-korea-postcode-search/) 포럼에 남겨주시면, 많은 분들께 도움이 됩니다.
--------------------------------------------------------------------------------------------------------------------
우커머스의 한국형 도로명 주소/ 우편번호 검색 플러그인 입니다.

해당 플러그인은 한국내 도로명 주소 및 우편번호 검색의 특수성에 따라 우커머스 사용이 불편하여 제작 하였습니다.
많은 한국 워드프레스 및 우커머스 사용자들이 해당 부분에 대해 불편을 겪으리라 생각되어 오픈하여 공개합니다.
사용에 따른 불편 사항 및 버그는 워드프레스 플러그인 소개부분의 코멘트 부분에 남겨주시기 부탁드리며,
공개 소프트웨어인 만큼 고객에 맞춘 기술지원은 불가합니다.

많은 사용자 분들께서 해당 플러그인에 발전에 기여 부탁드리며, 추가 개발/변경 된 부분에 대해서 공유를 원하시면,
beomps@gmail.com 으로 소스와 개발자 정보,코멘트를 알려주시면 해당 플러그인에 추가/변경 하여 재공유 하도록 하겠습니다.

상업/비상업적 용도로 무료로 사용 가능하며, 소스를 변경하여 재배포시 플러그인 소스 상단 개발자 정보에 대한 분리 표기 부탁드립니다.
재배포에 따른 변경 관리 책임은 재배포자에게 있습니다. 또한 재배포에 따른 다음 API 사용에 대한 라이센스는 필히 따로 연락/승인 받아서 사용하여야 합니다.
해당 플러그인의 성격상, 사용상 생길 수 있는 문제에 대한 책임은 사용자에게 있습니다.

플러그인을 사용함으로써 위 사항에 대해 동의하는 것으로 간주합니다.

다음 오픈 API 를 사용하여 제작되었습니다.

Beomps(박성범):
플러그인 공개에 흔쾌히 동의 해주신 다음 지도 팀(http://blog.daum.net/daummaps/565)에게 감사합니다.
조언을 준 동기들과 친구들에게 감사합니다.

개발 노트

*	  우커머스 결제에 영향이 최소화 되도록 체크아웃 필드에 대한 변경은 하지 않았습니다.
*	  필드 변경을 위해서는 custom_override_checkout_fields 함수의 unset을 사용하시면 각 필드들을 수정 하실 수 있습니다. ("성" 부분을 지우겠다, "회사명" 부분을 지우겠다, "도시" 부분을 지우겠다. etc)
*	  위의 필드 수정시에는 기존 워드프레스 사용자 청구/배송지 폼과 불일치가 발생할 수 있으며, PG 결제에 영향을 미칠 수 있으니 주의 하시기 바랍니다.
*     http 사용시와 https 사용시로 구분 작성 되었습니다. 어드민 패널에서 수정 가능합니다. (기본 http)
*	  다음 api 호출 스크립트의 action이 워드프레스 로딩시 로딩 되도록 작성 되어있습니다. 속도 향상을 위해 우커머스 체크아웃시만 한정 하실수 있으시면 변경 및 공유 부탁드립니다.



This plugin is Searcher Korea Postcode and road address.

This plugin made from specific Korea Postcode rule. Woocommerce can't support Korea Postcode. 
Many korean user in Wordpress and Woocommerce has uncomportable using checkout postcode form. So, share this plugin.
if you has issue or bug, write comments in wordpress comments page.
As open source plugin, Can't support individual technical services.

I hope, many user's this plugin contribute more enhance. If you want your add function or modify origin source, 
share your source and comments, information to "beomps@gmail". then I will redistribution this plugin.

Free use commercial/non-commercial. If you change source and redistribution, you must should mark developer information separately.
And you has take responsibility for management. Also you should give aproval at daum map teams.

Developer has no take responsibility for management. This plugin user has responsibility for all problems.

If you use this plugin, you will be agreeing to the above TERMS AND CONDITIONS by default

This plug in made from Daum Open API.

Beomps(park seong beom)
Thanks for Daum Map team(http://blog.daum.net/daummaps/565) to open this plugin.
Thanks for my co-worekers and friends.


Dev Note

*	  Changing checkout form fields for woocommerce charge.
*	  Available change checkout form fields through ' custom_override_checkout_fields' functions 'unset' code. (ex. Delete "lastname","company name","city"..etc)
*	  If you change checkout form fiels, can cause Paygate/User form's not same problems.  
*	  You can choose two modes, "http" or "https" through admin pannel
*	  When initiate wordpress page, active Daum API script. If you solve this problem for increase loading time, share for me.

======================================================================

Dev Note

*	  Changing checkout form fields for woocommerce charge.
*	  Available change checkout form fields through ' custom_override_checkout_fields' functions 'unset' code. (ex. Delete "lastname","company name","city"..etc)
*	  If you change checkout form fiels, can cause Paygate/User form's not same problems.  
*	  You can choose two modes, "http" or "https" through admin pannel
*	  When initiate wordpress page, active Daum API script. If you solve this problem for increase loading time, share for me.

== Installation ==

워드프레스 플러그인 설치 페이지를 통해 설치합니다.

문제가 있다면 아래 메뉴얼대로 하시면 됩니다.

1. `/wp-content/plugins/` 폴더에 압축을 푼 beomps-korea-post-search 폴더를 업로드 합니다.
2. 워드프레스 관리자 메뉴의 플러그인에서 위 플러그인을 활성화 시킵니다.

e.g.

1. Upload `beomps-korea-post-search` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress


== Frequently Asked Questions ==

1. start.

== Screenshots ==

1. screenshot-1.png [change] how to use1
2. screenshot-2.png [change] how to use2

== Changelog ==

= 3.3 =
* Bug fixed. - Doesn’t show ‘Find Postcode’ button after Woocommerce update. Thanks @Jinwook.
= 3.2 =
* Bug fixed. - Sentence error fixed for Ajax. Thanks @changwoo.
= 3.0 =
* Add admin pannel
* Add Find Postcode button to shipping page of account's page.
= 2.0 =
* Daum API ver2.0 - Change postcode style(5 digit)
* Change Form Unset Setting
= 1.0 =
* Open Korea Postcode Search plugin


== Upgrade Notice ==

= 3.0 =
* Admin upgrade.
= 2.0 =
* Daum API ver2.0 upgrade.
= 1.0 =

== Arbitrary section ==

== A brief Markdown Example ==
