<?php namespace PHPSTORM_META;

registerArgumentsSet(
	'manipulation_delete_opt',
	\Framework\Database\Manipulation\Delete::OPT_IGNORE,
	\Framework\Database\Manipulation\Delete::OPT_LOW_PRIORITY,
	\Framework\Database\Manipulation\Delete::OPT_QUICK,
);
expectedArguments(
	\Framework\Database\Manipulation\Delete::options(),
	0,
	argumentsSet('manipulation_delete_opt')
);
registerArgumentsSet(
	'manipulation_insert_opt',
	\Framework\Database\Manipulation\Insert::OPT_DELAYED,
	\Framework\Database\Manipulation\Insert::OPT_HIGH_PRIORITY,
	\Framework\Database\Manipulation\Insert::OPT_IGNORE,
	\Framework\Database\Manipulation\Insert::OPT_LOW_PRIORITY,
);
expectedArguments(
	\Framework\Database\Manipulation\Insert::options(),
	0,
	argumentsSet('manipulation_insert_opt')
);
registerArgumentsSet(
	'manipulation_load_data_opt',
	\Framework\Database\Manipulation\LoadData::OPT_CONCURRENT,
	\Framework\Database\Manipulation\LoadData::OPT_LOCAL,
	\Framework\Database\Manipulation\LoadData::OPT_LOW_PRIORITY,
);
expectedArguments(
	\Framework\Database\Manipulation\LoadData::options(),
	0,
	argumentsSet('manipulation_load_data_opt')
);
registerArgumentsSet(
	'manipulation_replace_opt',
	\Framework\Database\Manipulation\Replace::OPT_DELAYED,
	\Framework\Database\Manipulation\Replace::OPT_LOW_PRIORITY,
);
expectedArguments(
	\Framework\Database\Manipulation\Replace::options(),
	0,
	argumentsSet('manipulation_replace_opt')
);
registerArgumentsSet(
	'manipulation_select_opt',
	\Framework\Database\Manipulation\Select::OPT_ALL,
	\Framework\Database\Manipulation\Select::OPT_DISTINCT,
	\Framework\Database\Manipulation\Select::OPT_DISTINCTROW,
	\Framework\Database\Manipulation\Select::OPT_HIGH_PRIORITY,
	\Framework\Database\Manipulation\Select::OPT_SQL_BIG_RESULT,
	\Framework\Database\Manipulation\Select::OPT_SQL_BUFFER_RESULT,
	\Framework\Database\Manipulation\Select::OPT_SQL_CACHE,
	\Framework\Database\Manipulation\Select::OPT_SQL_CALC_FOUND_ROWS,
	\Framework\Database\Manipulation\Select::OPT_SQL_NO_CACHE,
	\Framework\Database\Manipulation\Select::OPT_SQL_SMALL_RESULT,
	\Framework\Database\Manipulation\Select::OPT_STRAIGHT_JOIN,
);
expectedArguments(
	\Framework\Database\Manipulation\Select::options(),
	0,
	argumentsSet('manipulation_select_opt')
);
registerArgumentsSet(
	'manipulation_update_opt',
	\Framework\Database\Manipulation\Update::OPT_IGNORE,
	\Framework\Database\Manipulation\Update::OPT_LOW_PRIORITY,
);
expectedArguments(
	\Framework\Database\Manipulation\Update::options(),
	0,
	argumentsSet('manipulation_update_opt')
);
registerArgumentsSet(
	'manipulation_with_opt',
	\Framework\Database\Manipulation\With::OPT_RECURSIVE
);
expectedArguments(
	\Framework\Database\Manipulation\With::options(),
	0,
	argumentsSet('manipulation_with_opt')
);
