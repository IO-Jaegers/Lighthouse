<?php
    namespace IoJaegers\Lighthouse\Utility\Client;

	
    class ClientInformation
    {
        public function __construct()
        {
			$rIp = $this->load();
			$this->setClientIp( $rIp );
        }
		
		public function load(): ?string
		{
			if( self::isSingletonClientIpAddrSet() )
			{
				return $this->getClientIp();
			}
			else
			{
				$rValue = $this->retrieve();
				
				$this->setClientIp( $rValue );
				self::setSingletonClientIpAddr( $rValue );
				
				return $rValue;
			}
		}
		
		protected function retrieve(): ?string
		{
			$value = null;
			
			$value = self::call_remote_addr();
			
			if( isset( $value ) )
			{
				return $value;
			}
			
			$value = self::call_http_x_forwarded_for();
			if( isset( $value ) )
			{
				return $value;
			}
			
			$value = self::call_http_client_ip();
			if( isset( $value ) )
			{
				return $value;
			}
			
			return null;
		}

		//
		private $client_ip = null;
		
		private static $singleton_client_ip_addr = null;
	
		//
		/**
		 * @return null
		 */
		public function getClientIp()
		{
			return $this->client_ip;
		}
	
		/**
		 * @param null $client_ip
		 */
		public function setClientIp( $client_ip ): void
		{
			$this->client_ip = $client_ip;
		}
		
		public function debug(): array
		{
			$values = array(
				'HTTP_CLIENT_IP' => self::call_http_client_ip(),
				'HTTP_X_FORWARDED_FOR' => self::call_http_x_forwarded_for(),
				'REMOTE_ADDR' => self::call_remote_addr()
			);
			
			return $values;
		}
		
		protected function call_http_client_ip()
		{
			$http_client_ip = $_SERVER[ 'HTTP_CLIENT_IP' ];
			
			if( isset( $http_client_ip ) )
			{
				return $http_client_ip;
			}
		
			return null;
		}
		
		protected function call_http_x_forwarded_for()
		{
			$http_client_ip = $_SERVER[ 'HTTP_X_FORWARDED_FOR' ];
			
			if( isset( $http_client_ip ) )
			{
				return $http_client_ip;
			}
			
			return null;
		}
		
		protected function call_remote_addr()
		{
			$remote_addr = $_SERVER['REMOTE_ADDR'];
			
			if( isset( $remote_addr ) )
			{
				return $remote_addr;
			}
			
			return null;
		}
	
		/**
		 * @return null
		 */
		public static function getSingletonClientIpAddr()
		{
			return self::$singleton_client_ip_addr;
		}
	
		/**
		 * @param null $singleton_client_ip_addr
		 */
		public static function setSingletonClientIpAddr( $singleton_client_ip_addr ): void
		{
			self::$singleton_client_ip_addr = $singleton_client_ip_addr;
		}
	
		public static function isSingletonClientIpAddrSet(): bool
		{
			return isset(self::$singleton_client_ip_addr);
		}
    }
?>