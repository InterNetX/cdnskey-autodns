<?xml version="1.0" encoding="utf-8"?>
<request>
	<auth>
		<user>{!! htmlspecialchars(config('autodns.user'), ENT_XML1) !!}</user>
		<password>{!! htmlspecialchars(config('autodns.password'), ENT_XML1) !!}</password>
		<context>{{ config('autodns.context') }}</context>
	</auth>
	<language>{{ config('autodns.language') }}</language>
	<task>
@yield('task')
		<reply_to>{{ config('autodns.replyto') }}</reply_to>
	</task>
</request>
