# Отношения
На данний момент отношений в базе на уровне foreign key - отсутствуют.
Однако между таблицами существует join-ы на основании индексов, которые просто не обозначены int-овыми полями.

Такие отношения это:

* company - estimates (one to one, estimate belongs to company)
* estimates - estimatesMeta (one to many)
* company - meta_price (one to many)
* company - reviews (one to many)
* company - videos (one to many)
