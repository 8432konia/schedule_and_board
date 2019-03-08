# 予定管理 ➕掲示板
フルスクラッチ（no jquery）で書きました。

主な設定はmodules/config.phpで行なってください。
sassを用いる場合は自分で用意をするか、<a href="https://github.com/konia-s/auto-gulp">こちら</a>を使ってください。

データベースのテーブルについて(カラム名:型)

・login ： id:int name:varchar email:varchar pass:varchar tel:varchar

・post  : id:int content:text date:date start:time end:time user_id:int

・bss   : id:int text:text datetime:datetime user_id:int

といった具合です。
