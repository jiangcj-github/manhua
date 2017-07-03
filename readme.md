### apache虚拟主机配置vhost.conf文件的内容如下:

    <VirtualHost *:80>
        DocumentRoot "C:/Users/DELL/Desktop/github/resourceServer"
        ServerName lindakai.com
        ErrorLog "logs/resourceServer-error.log"
        CustomLog "logs/resourceServer-access.log" common
        <Location /data/>
            AuthTokenSecret      "lindakai"
            AuthTokenPrefix      /data/
            AuthTokenTimeout     3600
            AuthTokenLimitByIp   on
        </Location>
    </VirtualHost>

    <VirtualHost *:80>
        DocumentRoot "C:/Users/DELL/Desktop/github/manhua"
        ServerName test1.com
        ErrorLog "logs/manhua-error.log"
        CustomLog "logs/manhua-access.log" common
    </VirtualHost>

### 需要配置mod_auto_token


