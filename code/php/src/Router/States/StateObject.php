<?php
    namespace IoJaegers\Lighthouse\Router\States;


    /**
     *
     */
    abstract class StateObject
        implements StateInterface
    {
        public function __construct()
        {
            $this->setDetectState( 0 );
        }

        // Variables
        private ?int $detect_state;


        // Accessors
        /**
         * @return int|null
         */
        public function getDetectState(): ?int
        {
            return $this->detect_state;
        }

        /**
         * @param int|null $detect_state
         */
        public function setDetectState( ?int $detect_state ): void
        {
            $this->detect_state = $detect_state;
        }
    }
?>