# strawberry
MySQL Process List Spy

---

![Icon](https://github.com/sinri/strawberry/blob/master/docs/strawberry.jpeg?raw=true)

Put An Uneatable Strawberry Here For Remembrance.

---

Usage:

```bash
php Strawberry.php [ConfigFile] [StoreDir] [Time]

# Such as:
# php bin/Strawberry.php debug/config.php debug 10
```

Config file see `config/pdo_sample.php`.

Store Directory should be writable.

Time is an integer, unit is second.

To be run in cronjob and collected slow log would be put in store directory.

---

阿里云的基础版 MySQL RDS 是不提供慢日志服务的。

> 自力更生，艰苦奋斗。打倒列强，除军阀！